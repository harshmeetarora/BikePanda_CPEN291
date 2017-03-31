#include <ArduinoJson.h>
#include <LiquidCrystal.h>
#include <EEPROM.h>
#include <Adafruit_GPS.h>
#include <SoftwareSerial.h>
#include <math.h>

#define hallPin A3
#define photocell A0
#define taillights A5
#define interruptPin 3

/*
 * Constants used in speed/distance calculations: 
 */
const float wheelDiameter = 0.6858; // in m
const float numMagnets = 3.0;
const float pi = 3.14159;
// Calculate the min RPS of the wheel based
// on a max speed of 15m/s, min speed of 0.3m/s :
// const unsigned long maxRPS = 15/(wheelDiameter*pi);  
const double minRPS = 0.3/(wheelDiameter*pi); 
const int address = 10;

/* 
 * Global variables to display:  
 */
int bikeSpeed = 0;  // Speed in km/h
float totalDistance;  // units of distance: metres
volatile float tripDistance; 
volatile int tripID;
double latitude; 
double longitude;
double altitude; 

/*
 * Hidden global variables: 
 */
// Flag indicates if the magnet is adjacent to the Hall Effect Sensor
char magnetFlag = 0;
// Reset acts as an "enable pin" for debouncing the speed calculation,
// magnetFlag can't be set to 1 unless magnetReset is 1
char magnetReset = 0;  

// Records when the magnet last passed the sensor,
unsigned long lastInterrupt = 0.0; // used for calculating speed
unsigned long lastSpeedCalc = 0.0; // used to stabilize speed calculation
unsigned long lastPiTransmit = 0.0; // used to regulate data transmission intervals
unsigned long lastGPScheck = 0.0; // used to regulate gps readings
// For GPS: 
String NMEA1;  //We will use this variable to hold our first NMEA sentence
String NMEA2;  //We will use this variable to hold our second NMEA sentence
char c;        //Used to read the characters spewing from the GPS module

// initialize the library with the numbers of the interface pins
LiquidCrystal lcd(12, 11, 7, 6, 5, 4);
SoftwareSerial gpsSerial(10, 9);
Adafruit_GPS GPS(&gpsSerial);

void setup() 
{
  Serial.begin(9600);
  pinMode(hallPin, INPUT_PULLUP);
  pinMode(LED_BUILTIN, OUTPUT);
  pinMode(photocell, INPUT);
  pinMode(interruptPin, INPUT_PULLUP);
  pinMode(taillights, OUTPUT);
  attachInterrupt(digitalPinToInterrupt(interruptPin),tripCount,RISING);
 
  GPS.begin(9600);
  GPS.sendCommand("$PGCMD,33,0*6D"); // Turn Off GPS Antenna Update  
  GPS.sendCommand(PMTK_SET_NMEA_OUTPUT_RMCGGA);
  GPS.sendCommand(PMTK_SET_NMEA_UPDATE_1HZ);   // 1 Hz update rate

  // set up the LCD's number of columns and rows:
  lcd.begin(16, 2);
  // Print a message to the LCD.
  lcd.print("Ready to ride?");
  delay(1000);
  lcd.clear();
  totalDistance = EEPROM.read(address);
  tripDistance = EEPROM.read(address+10);
  tripID = EEPROM.read(address+20);
  updateLCD();
}

void loop() 
{
  checkForMagnet();
  updateDistances();
  updateBikeSpeed();
  if(analogRead(photocell) < 500) {
    digitalWrite(taillights, HIGH);
  } else {
    digitalWrite(taillights, LOW); // updateTaillights();
  } 
  magnetFlag ? digitalWrite(LED_BUILTIN, HIGH) : digitalWrite(LED_BUILTIN, LOW);
//  readGPS();  //reads two NMEA sentences from GPS
  if(millis()-lastGPScheck > 20000){
    readGPS();
    checkForMagnet();
    updateDistances();
    updateBikeSpeed();
    if(GPS.fix==1){
      latitude = convertDegMinToDecDeg(GPS.latitude);
      longitude = -1.0*convertDegMinToDecDeg(GPS.longitude);
      altitude = GPS.altitude/100.0;
    }
  } 
  if(millis()-lastPiTransmit > 2000)
    sendToPi();
}

void updateLCD()
{
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("km/h  Dist  Trip");
  lcd.setCursor(0,1);
  lcd.print(bikeSpeed);
  if(totalDistance < 100){ // max val to display is 999.9km
    lcd.setCursor(6,1);
    lcd.print(totalDistance,0);
    lcd.print("m");
  } else if (totalDistance < 10000) {
    lcd.setCursor(6,1);
    lcd.print(totalDistance/1000.0,1);
    lcd.print("km");
  } else {
    lcd.setCursor(5,1);
    lcd.print(totalDistance/1000.0,1);
    lcd.print("km");    
  }
  if(tripDistance < 1000){ // max val to display is 99.9km
    lcd.setCursor(12,1);
    lcd.print(tripDistance,0);
    lcd.print("m");
  } else if (tripDistance < 10000) {
    lcd.setCursor(11,1);
    lcd.print(tripDistance/1000.0,1);
    lcd.print("km");
  } else {
    lcd.setCursor(10,1);
    lcd.print(tripDistance/1000.0,1);
    lcd.print("km");    
  }
}

// Speedometer: updates global bike speed variable 
// using time interval between last two magnet detections
void updateBikeSpeed()
{
  long period = millis()-lastInterrupt;
  if(!magnetFlag){
    if(period>(1000.0/minRPS/numMagnets))
    { 
      bikeSpeed=0;
      if(millis() - lastSpeedCalc > 200){
         updateLCD();
         lastSpeedCalc = millis();
      }
    }
  } else { //3.6*1m/s = 1km/h, period/1000 converts from us to s
    bikeSpeed = 3.6*(pi*wheelDiameter/numMagnets)/(period/1000.0); 
    lastInterrupt = millis();
    if(millis() - lastSpeedCalc > 200) {    
      updateLCD();
      lastSpeedCalc = millis(); 
    }
  } 
}

// Checks whether the magnet is next to the sensor, 
// filtering out multiple readings of one magnet pass
void checkForMagnet()
{
  if(analogRead(hallPin)<50)
  {
    if(magnetReset==0){ 
      magnetFlag = 0;  // Logic to prevent multiple readings of one pass
    } else { 
      magnetFlag = 1;
      magnetReset = 0;
    } 
  } else { 
    magnetFlag = 0;
    magnetReset = 1; 
  }
}

// Odometer
void updateDistances()
{
  if(magnetFlag)
  {
    totalDistance += (pi*wheelDiameter/numMagnets);
    tripDistance  += (pi*wheelDiameter/numMagnets);    
    EEPROM.write(address,totalDistance);
    EEPROM.write(address+10,tripDistance);
  }
}

// ISR for when the "Trip Reset" button is pressed
void tripCount()
{
  tripDistance = 0.0;
  EEPROM.write(address+10,tripDistance);
  tripID = tripID+1;
  EEPROM.write(address+20, tripID);
}

// Sends a packet of our rider's data to the Raspberry Pi
// Using the serial connection
void sendToPi()
{
    DynamicJsonBuffer jsonBuffer;
    JsonObject& root = jsonBuffer.createObject();
    root["Bike_Speed"] = bikeSpeed;
    root["Trip_Distance"] = EEPROM.read(address+10);
    root["Total_Distance"] = EEPROM.read(address); 
    root["Trip_ID"] = EEPROM.read(address+20);
    root["Latitude"] = double_with_n_digits(latitude,5);
    root["Longitude"] = double_with_n_digits(longitude,5);
    root["Altitude"] = altitude;
    root.printTo(Serial);
    Serial.println();
    lastPiTransmit = millis();
}

//This function will read and remember two NMEA sentences from GPS
void readGPS()
{  
  clearGPS();    //Serial port probably has old or corrupt data, so begin by clearing it all out
  while(!GPS.newNMEAreceived()) { //Keep reading characters in this loop until a good NMEA sentence is received
    c=GPS.read(); //read a character from the GPS
  }
  checkForMagnet();
  updateDistances();
  updateBikeSpeed();
  GPS.parse(GPS.lastNMEA());  //Once you get a good NMEA, parse it
  NMEA1=GPS.lastNMEA();      //Once parsed, save NMEA sentence into NMEA1
  while(!GPS.newNMEAreceived()) {  //Go out and get the second NMEA sentence, should be different type than the first one read above.
    c=GPS.read();
  }
  checkForMagnet();
  updateDistances();
  updateBikeSpeed();
  GPS.parse(GPS.lastNMEA());
  NMEA2=GPS.lastNMEA();
  lastGPScheck = millis();
}

void clearGPS() 
{  
  //Since between GPS reads, we still have data streaming in, we need to clear the old data by reading a few sentences, and discarding these
  while(!GPS.newNMEAreceived()) {
    c=GPS.read();
  }
  checkForMagnet();
  updateDistances();
  updateBikeSpeed();
  GPS.parse(GPS.lastNMEA());
  while(!GPS.newNMEAreceived()) {
    c=GPS.read();
  }
  checkForMagnet();
  updateDistances();
  updateBikeSpeed();
  GPS.parse(GPS.lastNMEA());
}

double convertDegMinToDecDeg (float degMin) 
{
  double minutes = 0.0;
  double decDeg = 0.0;
 
  //get the minutes, fmod() requires double
  minutes = fmod((double)degMin, 100.0);
 
  //rebuild coordinates in decimal degrees
  degMin = (int) ( degMin / 100 );
  decDeg = degMin + ( minutes / 60 );
 
  return decDeg;
}

