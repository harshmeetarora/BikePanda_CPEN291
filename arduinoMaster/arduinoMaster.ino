#include <ArduinoJson.h>
#include <LiquidCrystal.h>
#include <EEPROM.h>
#define hallPin A1
#define tripSwitch 8
#define photocell A5
#define taillights A3
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
const int address = 0;

/* 
 * Global variables to display:  
 */
int bikeSpeed = 0;  // Speed in km/h
float totalDistance;  // units of distance: metres
volatile float tripDistance; 
volatile int tripID;

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

// initialize the library with the numbers of the interface pins
LiquidCrystal lcd(12, 11, 7, 6, 5, 4);

void setup() 
{
  Serial.begin(9600);
  pinMode(hallPin, INPUT_PULLUP);
  pinMode(LED_BUILTIN, OUTPUT);
  pinMode(tripSwitch, INPUT);
  pinMode(photocell, INPUT);
  pinMode(interruptPin, INPUT_PULLUP);
  pinMode(taillights, OUTPUT);
  attachInterrupt(digitalPinToInterrupt(interruptPin),tripCount,RISING);
  // set up the LCD's number of columns and rows:
  lcd.begin(16, 2);
  // Print a message to the LCD.
  lcd.print("Ready to ride?");
  delay(1000);
  lcd.clear();
  totalDistance = EEPROM.read(address);
  tripDistance = EEPROM.read(address+1);
  tripID = EEPROM.read(address+2);
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
  if( millis()-lastPiTransmit > 2000)
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
    EEPROM.write(address,totalDistance);
    tripDistance  += (pi*wheelDiameter/numMagnets);
    EEPROM.write(address+1,tripDistance);
  }
  if(digitalRead(tripSwitch)){
    
  }
}

// ISR for when the "Trip Reset" button is pressed
void tripCount()
{
  tripDistance = 0.0;
  EEPROM.write(address+1,tripDistance);
  tripID = tripID+1;
  EEPROM.write(address+2, tripID);
}

// Sends a packet of our rider's data to the Raspberry Pi
// Using the serial connection
void sendToPi()
{
    DynamicJsonBuffer jsonBuffer;
    JsonObject& root = jsonBuffer.createObject();
    root["Bike_Speed"] = bikeSpeed;
    root["Trip_Distance"] = tripDistance;
    root["Total_Distance"] = totalDistance; 
    root["Trip_ID"] = EEPROM.read(address+2);   
    root.printTo(Serial);
    Serial.println();
    lastPiTransmit = millis();
}
