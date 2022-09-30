#!/usr/bin/python3
# -*- coding: utf-8 -*-
# v=1.2

import mysql.connector
import time
import _thread
import requests
from datetime import datetime, timedelta, timezone 
import paho.mqtt.client as mqtt


# print(int("1ffe",16))
# exit()

WEBHOOK = "https://hooks.zapier.com/hooks/catch/7735479/bevcycu/"
# WEBHOOK = "https://hooks.com"
HEADER = {'Content-Type': 'application/x-www-form-urlencoded'}
brokerAddress="vernemq" 
clientID="0006"
userName="alerts"
userPassword="c89ff4515c3070781ce3ac7ad99f975fed329fbb"
mqttc = mqtt.Client(clientID)


def MQTT_Loop(HOST, UN, PWD):
    global mqttc
    tzinfo = timezone(timedelta(hours=8))
    print("<"+str(datetime.now(tzinfo))[:23]+">")    
    print("[MQTT_Loop] Service started")     
    while 1:
        mqttc.username_pw_set(UN, password=PWD)
        mqttc.will_set("/FSSN/USVC/ALERTS/STATUS","DISCONNECTED",1,True)
        mqttc.connect(HOST)
        mqttc.publish("/FSSN/USVC/ALERTS/STATUS","CONNECTED",1, True)
        time.sleep(1)
        print("Start mqtt receiving loop")
        mqttc.loop_forever() 
        print("Mqtt loop interrupted")
        time.sleep(2)


def AlertAirQuality():
    global mqttc
    T0 = time.time()
    Interval = 60
    Expiry = 3600
    
    tzinfo = timezone(timedelta(hours=8))
    print("<"+str(datetime.now(tzinfo))[:23]+">")    
    print("[AlertAirQuality] Service started")    
    while 1: 
        Td = time.time() - T0
        if Td > Interval:
            print("<"+str(datetime.now(tzinfo))[:23]+">")            
            print("[AlertAirQuality] Check air-quality")
            db = mysql.connector.connect(
              host="database",
              user="usvc",
              password="O0zg2mbfs9!VQbM-",
              database="sensor_db"
            )    
            cursor = db.cursor(dictionary=True,buffered=True)            
            T0 = time.time()
            cursor.execute("SELECT `NODES`.`MAC` as 'ID',`FACILITIES`.`NAME` as 'FAC',`LOCATION_NAME` as 'LOC',`NODES`.`NAME` as 'NODE',`CHECKVALUE`,`THRESHOLD`,`SUPERVISOR_UID`,`USERS`.`DISPLAY_NAME` as 'CLEANER_NAME',`USERS`.`EMAIL` as 'CLEANER_EMAIL',`USERS`.`PHONE` as 'CLEANER_PHONE' FROM `NODES` LEFT JOIN `RL_LOC_NODES` ON `NODES`.`MAC`=`RL_LOC_NODES`.`MAC` LEFT JOIN `LOCATIONS` ON `LOCATIONS`.`LOCATION_UID`=`RL_LOC_NODES`.`LOC_UID` LEFT JOIN `FACILITIES` ON `FACILITIES`.`UID`=`LOCATIONS`.`FACILITY_UID` LEFT JOIN `USERS` ON `USERS`.`CODE`=`LOCATIONS`.`CLEANER_UID` WHERE `CHECKVALUE`>`THRESHOLD` AND `SENSOR_TYPE` LIKE 'a9' ORDER BY `RL_LOC_NODES`.`MAC` ASC;")
            result = cursor.fetchall()
            ROW_COUNT = cursor.rowcount
            for row in result:
                ID = row['ID']
                FAC = row['FAC']
                LOC = row['LOC']
                NODE = row['NODE']
                THR = row['THRESHOLD']
                S_UID = row['SUPERVISOR_UID']
                C_NAME = row['CLEANER_NAME']
                C_EMAIL = row['CLEANER_EMAIL']
                C_PHONE = row['CLEANER_PHONE']                  
                cursor.execute("SELECT `DISPLAY_NAME` as 'NAME',`EMAIL`,`PHONE` FROM `USERS` WHERE `CODE`='"+S_UID+"';");
                r_1 = cursor.fetchone()
                S_NAME = r_1['NAME']
                S_EMAIL = r_1['EMAIL']
                S_PHONE = r_1['PHONE']
                
                cursor.execute("SELECT unix_timestamp(`EXPIRY`) as 'EXP' FROM `NOTIFICATIONS` WHERE `MAC`='"+ID+"' ORDER BY `NOTIFICATIONS`.`TIME` DESC LIMIT 1;")
                if cursor.rowcount > 0:
                    r_2 = cursor.fetchone()
                    NOTIFICATION_EXPIRY = r_2['EXP']
                else: 
                    NOTIFICATION_EXPIRY = 0
                if  T0 > NOTIFICATION_EXPIRY:
                    # print(FAC,LOC,NODE,THR,S_NAME,S_PHONE,S_EMAIL,C_NAME,C_EMAIL,C_PHONE)
                    MSG = NODE+" at "+FAC+", "+LOC+" air-quality reading exceeds "+str(THR)+"."
                    DATA = "SensorID="+ID+"&Phone1="+S_PHONE+"&Phone2="+C_PHONE+"&Message='"+MSG.replace(" ","%20")+"'"
                    x = requests.post(WEBHOOK, data = DATA, headers=HEADER)
                    print("[AlertAirQuality] SENT> "+DATA+"\nRECEIVED> "+x.text)
                    mqttc.publish("/FSSN/USVC/ALERT/EVENT",DATA,1, False)
                    with open("logs", "a+") as myfile:
                        myfile.write("<"+str(datetime.now(tzinfo))[:23]+">\n"+MSG+"\n")
                    cursor.execute("INSERT INTO `NOTIFICATIONS`(`MAC`,`TIME`,`MESSAGE`,`NOTIFIED_USERS`,`EXPIRY`) VALUES ('"+ID+"',NOW(),'"+MSG+"','[\""+S_NAME+"\",\""+C_NAME+"\"]', FROM_UNIXTIME("+str(T0+Expiry)+"));")
                    # print("INSERT INTO `NOTIFICATIONS`(`MAC`,`TIME`,`MESSAGE`,`NOTIFIED_USERS`,`EXPIRY`) VALUES ('"+ID+"',NOW(),'"+MSG+"','[\""+S_NAME+"\",\""+C_NAME+"\"]', FROM_UNIXTIME("+str(T0+Expiry)+"));")
                else:
                    print("[AlertAirQuality] Within notification expiration period")
                db.commit()                    
            if ROW_COUNT == 0:
                print("[AlertAirQuality] Air-quality reading within threshold")
            cursor.close()
            db.close()
            time.sleep(1)


def AlertMotionCount():
    global mqttc
    T0 = time.time()
    Interval = 10
    tzinfo = timezone(timedelta(hours=8))
    print("<"+str(datetime.now(tzinfo))[:23]+">")    
    print("[AlertMotionCount] Service started")
    while 1: 
        Td = time.time() - T0
        if Td > Interval:
            print("<"+str(datetime.now(tzinfo))[:23]+">")            
            print("[AlertMotionCount] Check detection count")
            db = mysql.connector.connect(
              host="database",
              user="usvc",
              password="O0zg2mbfs9!VQbM-",
              database="sensor_db"
            )    
            cursor = db.cursor(dictionary=True,buffered=True)            
            T0 = time.time()
            cursor.execute("SELECT `NODES`.`MAC` as 'ID',`FACILITIES`.`NAME` as 'FAC',`LOCATION_NAME` as 'LOC',`NODES`.`NAME` as 'NODE',`CHECKVALUE`,`THRESHOLD`,`SUPERVISOR_UID`,`USERS`.`DISPLAY_NAME` as 'CLEANER_NAME',`USERS`.`EMAIL` as 'CLEANER_EMAIL',`USERS`.`PHONE` as 'CLEANER_PHONE' FROM `NODES` LEFT JOIN `RL_LOC_NODES` ON `NODES`.`MAC`=`RL_LOC_NODES`.`MAC` LEFT JOIN `LOCATIONS` ON `LOCATIONS`.`LOCATION_UID`=`RL_LOC_NODES`.`LOC_UID` LEFT JOIN `FACILITIES` ON `FACILITIES`.`UID`=`LOCATIONS`.`FACILITY_UID` LEFT JOIN `USERS` ON `USERS`.`CODE`=`LOCATIONS`.`CLEANER_UID` WHERE `CHECKVALUE`>`THRESHOLD` AND `SENSOR_TYPE` LIKE '03' ORDER BY `RL_LOC_NODES`.`MAC` ASC;")
            result = cursor.fetchall()
            ROW_COUNT = cursor.rowcount
            for row in result:
                ID = row['ID']
                FAC = row['FAC']
                LOC = row['LOC']
                NODE = row['NODE']
                THR = row['THRESHOLD']
                S_UID = row['SUPERVISOR_UID']
                C_NAME = row['CLEANER_NAME']
                C_EMAIL = row['CLEANER_EMAIL']
                C_PHONE = row['CLEANER_PHONE']                  
                cursor.execute("SELECT `DISPLAY_NAME` as 'NAME',`EMAIL`,`PHONE` FROM `USERS` WHERE `CODE`='"+S_UID+"';");
                r_1 = cursor.fetchone()
                S_NAME = r_1['NAME']
                S_EMAIL = r_1['EMAIL']
                S_PHONE = r_1['PHONE']
                # print(FAC,LOC,NODE,THR,S_NAME,S_PHONE,S_EMAIL,C_NAME,C_EMAIL,C_PHONE)
                MSG = NODE+" at "+FAC+", "+LOC+" traffic counter exceeds "+str(THR)+"."
                DATA = "SensorID="+ID+"&Phone1="+S_PHONE+"&Phone2="+C_PHONE+"&Message='"+MSG.replace(" ","%20")+"'"
                x = requests.post(WEBHOOK, data = DATA, headers=HEADER)
                print("[AlertMotionCount] SENT> "+DATA+"\nRECEIVED> "+x.text)
                mqttc.publish("/FSSN/USVC/ALERT/EVENT",DATA,1, False)
                with open("logs", "a+") as myfile:
                    myfile.write("<"+str(datetime.now(tzinfo))[:23]+">\n"+MSG+"\n")            
            if ROW_COUNT != 0:
                print("[AlertMotionCount] Reset detection count")
                cursor.execute("UPDATE `NODES` SET `CHECKVALUE`=0 WHERE `CHECKVALUE`>`THRESHOLD` AND `SENSOR_TYPE` LIKE '03';")
                cursor.execute("INSERT INTO `NOTIFICATIONS`(`MAC`,`TIME`,`MESSAGE`,`NOTIFIED_USERS`,`EXPIRY`) VALUES ('"+ID+"',NOW(),'"+MSG+"','[\""+S_NAME+"\",\""+C_NAME+"\"]',NOW());")
                db.commit()
            else:
                print("[AlertMotionCount] Detection count within threshold")
            cursor.close()
            db.close()
            time.sleep(1)

_thread.start_new_thread( AlertMotionCount, () )  
_thread.start_new_thread( AlertAirQuality, () )  
_thread.start_new_thread( MQTT_Loop,(brokerAddress, userName, userPassword))  

while 1:
    time.sleep(60)
    