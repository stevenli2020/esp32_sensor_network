#!/usr/bin/python3
# -*- coding: utf-8 -*-
# v=1.2

import paho.mqtt.client as mqtt
import mysql.connector
import time


brokerAddress="vernemq" 
clientID="0001"
userName="events"
userPassword="3e90edbe0f6cbef1cec300719e684a0e5de648a7"
dataBuffer=[]


# print(int("1ffe",16))
# exit()


def on_message(mosq, obj, msg):
    in_data = str(msg.payload)[2:-1]
    print(msg.topic + " - " + in_data)
    TOPIC=msg.topic.split("/")
    if "/STATUS" not in msg.topic:
        if in_data in dataBuffer:
            return
        else:
            dataBuffer.append(in_data)
            if len(dataBuffer)>256:
                del dataBuffer[0] 
    MSG=(in_data).split(":")
    db = mysql.connector.connect(
      host="database",
      user="usvc",
      password="O0zg2mbfs9!VQbM-",
      database="sensor_db"
    )    
    cursor = db.cursor(dictionary=True)  
    if TOPIC[2]!="USVC" and TOPIC[3]=="E":
        COORDINATOR_ID=TOPIC[2]
        CLUSTER_ID=TOPIC[4]
        NODE_ID=TOPIC[5]
        EVENT_ID=int(MSG[1], 16)
        NODE_TYPE=MSG[0]
        NODE_BATT=int(MSG[2], 16)
        NODE_DATA=int(MSG[3], 16)
        if NODE_TYPE=="03":
            if NODE_DATA==0:
                NODE_DATA=1
            sql="SELECT * FROM `EVENTS` WHERE `NODE_ID`='"+NODE_ID+"' ORDER BY `ID` DESC LIMIT 1;";
            cursor.execute(sql)
            R = cursor.fetchone()
            EVENT_ID_LAST = R['EVENT_ID']
            if (EVENT_ID-EVENT_ID_LAST) > NODE_DATA:
                NODE_DATA = EVENT_ID - EVENT_ID_LAST
        print(str(EVENT_ID)+" - "+str(NODE_TYPE)+","+str(NODE_BATT)+","+str(NODE_DATA))            
        sql = "INSERT INTO `EVENTS` (`COORDINATOR`, `CLUSTER_ID`, `NODE_ID`, `TYPE`, `DATA_TYPE`, `EVENT_ID`, `BAT_LVL`, `SENSOR_DATA`) VALUES ('"+COORDINATOR_ID+"','"+CLUSTER_ID+"','"+NODE_ID+"','E','"+NODE_TYPE+"',"+str(EVENT_ID)+","+str(NODE_BATT)+","+str(NODE_DATA)+")"
        cursor.execute(sql)
        # db.commit()
        sql = "UPDATE `NODES` SET `EVENT_ID`="+str(EVENT_ID)+",`CLUSTER_ID`='"+CLUSTER_ID+"',`SENSOR_TYPE`='"+NODE_TYPE+"',`PARENT`='"+COORDINATOR_ID+"',`BATT_LVL`="+str(NODE_BATT)+",`SENSOR_DATA`="+str(NODE_DATA)+" WHERE `MAC`='"+NODE_ID+"'"
        # print(sql)
        cursor.execute(sql)
        db.commit()
    elif TOPIC[2]!="USVC" and TOPIC[3]=="STATUS":
        COORDINATOR_ID=TOPIC[2]
        if str(msg.payload)[2:-1]=='CONNECTED':
            STATUS = "1"
        else:
            STATUS = "0"
            print(str(msg.payload).strip())
        print("Coordinator "+COORDINATOR_ID+" status - "+STATUS)     
        sql = "UPDATE `COORDINATORS` SET `CONNECTED`="+STATUS+" WHERE `MAC`='"+COORDINATOR_ID+"';"
        cursor.execute(sql)   
        sql = "INSERT INTO `STATUS_EVENTS` (`TIME`, `NAME`, `EVENT`) VALUES (NOW(),'"+TOPIC[2]+"','"+str(msg.payload)[2:-1]+"');"
        cursor.execute(sql)        
        db.commit() 
    elif TOPIC[2]=="USVC":
        sql = "INSERT INTO `STATUS_EVENTS` (`TIME`, `NAME`, `EVENT`) VALUES (NOW(),'"+TOPIC[2]+"-"+TOPIC[3]+"','"+(str(msg.payload)[2:-1]).replace("'","")+"');"
        cursor.execute(sql)        
        db.commit()        
    cursor.close()
    db.close()
   

mqttc = mqtt.Client(clientID)
mqttc.username_pw_set(userName, password=userPassword)
mqttc.will_set("/FSSN/USVC/EVENTS/STATUS","DISCONNECTED",1,True)
mqttc.on_message = on_message
mqttc.connect(brokerAddress)
mqttc.subscribe("/FSSN/#")
mqttc.publish("/FSSN/USVC/EVENTS/STATUS","CONNECTED",1, True)
time.sleep(1)
print("Start mqtt receiving loop")
mqttc.loop_forever()
