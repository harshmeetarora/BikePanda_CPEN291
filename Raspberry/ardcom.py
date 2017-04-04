import serial
import json
import requests

try:
    ser = serial.Serial('/dev/ttyACM0', 9600)
except serial.SerialException:
    ser = serial.Serial('/dev/ttyACM1', 9600)
url = 'http://38.88.74.90/pi_readings.php'
while 1:
    
    payload = ser.readline().decode().strip()
    
    r = requests.post(url, payload)
    #print(payload)
    print(r.text)