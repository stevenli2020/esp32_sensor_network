FROM ubuntu:20.04
RUN apt-get update 
RUN apt-get install -y python3 python3-pip
RUN pip install paho-mqtt
RUN pip install mysql-connector-python requests
RUN mkdir /app
RUN apt-get clean

WORKDIR /app
CMD ["python3", "run.py"]
