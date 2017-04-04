import serial
import json
import requests


# try catch statement to try both ports for connection
try:
    ser = serial.Serial('/dev/ttyACM0', 9600)
except serial.SerialException:
    ser = serial.Serial('/dev/ttyACM1', 9600)
url = 'http://38.88.74.90/pi_readings.php'
while 1:
    # read serial input from arduino
    payload = ser.readline().decode().strip()
    # post serial line to server 
    r = requests.post(url, payload)
    #print(payload)
    print(r.text)