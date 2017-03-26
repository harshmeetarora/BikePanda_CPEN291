#!/usr/bin/env python3
import requests 

# read from arduino
# speed = readFromArduino()
#Speed : 10 : Trip distance : 200 : Total distance : 1000 /r/n

payload = {inData}
r = requests.post("http://38.88.74.90/hello.php", data=payload)
print(r.text)

url = 'http://httpbin.org/post'
files = {'file': ('report.xls', open('report.xls', 'rb'), 'application/vnd.ms-excel', {'Expires': '0'})}
r = requests.post(url, files=files)
print(r.text)