#!/usr/bin/python3
# -*- coding: utf-8 -*-

import mysql.connector
import time
import requests
from datetime import datetime, timedelta, timezone 


_count = "100"
_sensorID = "TEST_STEVEN"
URL = 'https://hooks.zapier.com/hooks/catch/7735479/bm7idt6/'
HEADER = {'Content-Type': 'application/x-www-form-urlencoded'}
try:

    while 1:
        db = mysql.connector.connect(
          host="database",
          user="usvc",
          password="O0zg2mbfs9!VQbM-",
          database="sensor_db"
        )
        cursor = db.cursor(dictionary=True)    
        cursor.execute("SELECT * FROM NODES")
        result = cursor.fetchall()
        tzinfo = timezone(timedelta(hours=8))
        print("<"+str(datetime.now(tzinfo))[:23]+">")
        for row in result:
            CLUSTER_ID = row['CLUSTER_ID']
            NODE_ID = row['MAC']
            cursor.execute("select count(*) as CNT from EVENTS where TIME >= DATE_SUB(NOW(),INTERVAL 30 MINUTE) AND NODE_ID='"+NODE_ID+"';")
            R = cursor.fetchone()
            DATA = "Count=%d SensorID=%s" % (R['CNT'],CLUSTER_ID+"-"+NODE_ID)
            x = requests.post(URL, data = DATA, headers=HEADER)
            print("[SENT] "+DATA+"\n[RECEIVED]: "+x.text)
            time.sleep(1)
        cursor.close()
        db.close()   
        print("\n")
        dt = datetime.now() + timedelta(minutes=30)
        while datetime.now() < dt:
            time.sleep(2)
    
except Exception as ex:
    print(ex)
    print("Error occurred, exit")

