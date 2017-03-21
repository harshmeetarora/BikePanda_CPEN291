#include <LiquidCrystal.h>
#define hallPin A1
#define tripSwitch 8

const float wheelDiameter = 0.6858; // in m
const float numMagnets = 8.0;
const float pi = 3.14159;

// Calculate the max/min RPS of the wheel based
// on a max speed of 15m/s, min speed of 0.3m/s
const unsigned long maxRPS = 15/(wheelDiameter*pi);  
const double minRPS = 0.3/(wheelDiameter*pi); 

int bikeSpeed = 0;  // Speed in km/h TODO: Decide if we want this to be a float
int totalDistance = 0; // TODO: Decide units of distance... metres?
int tripDistance = 0; // TODO: decide what should happen if the odomoter overflows 
                      // (max val now is 99999, only 100km)

// Flag indicates if the magnet is adjacent to the Hall Effect Sensor
char magnetFlag;
// Reset tells us if the magnet (by the sensor) has only just arrived there
// for debouncing the speed calculation
char magnetReset = 1;  

// Records when  the magnet last passed the sensor,
unsigned long lastInterrupt = 0.0; // used for calculting speed

// initialize the library with the numbers of the interface pins
LiquidCrystal lcd(12, 11, 7, 6, 5, 4);

void setup() 
{
  Serial.begin(9600);
  pinMode(hallPin, INPUT_PULLUP);
  pinMode(LED_BUILTIN, OUTPUT);
  pinMode(tripSwitch, INPUT);
  // set up the LCD's number of columns and rows:
  lcd.begin(16, 2);
  // Print a message to the LCD.
  lcd.print("Ready to ride?");
  delay(1500);
  lcd.clear();
  updateLCD();
}

void loop() 
{
  checkForMagnet();
  updateDistances();
  updateBikeSpeed();
  magnetFlag ? digitalWrite(LED_BUILTIN, HIGH) : digitalWrite(LED_BUILTIN, LOW);
  delay(150);
}

void updateLCD()
{
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("km/h  Dist  Trip");
  lcd.setCursor(0,1);
  lcd.print(bikeSpeed);
  lcd.setCursor(6,1);
  lcd.print(totalDistance);
  lcd.setCursor(12,1);
  lcd.print(tripDistance);
}

// Updates global bike speed variable using time since 
// if a magnet is detected last interrupt
void updateBikeSpeed()
{
  long period = millis()-lastInterrupt;
  if(!magnetFlag){
    if(period>(1000.0/minRPS/numMagnets))
    { 
      bikeSpeed=0.0;
      updateLCD();
    }
  } else { //3.6*1m/s = 1km/h, period/1000 converts from us to s
    bikeSpeed = 3.6*(pi*wheelDiameter/numMagnets)/(period/1000.0); 
    lastInterrupt = millis();
    updateLCD();
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
      magnetFlag=1;
      magnetReset=0;
    } 
  } else { 
    magnetFlag = 0;
    magnetReset = 1; 
  }
}

// Odometer
void updateDistances(){
  if(magnetFlag)
  {
    totalDistance += (pi*wheelDiameter/numMagnets);
    tripDistance  += (pi*wheelDiameter/numMagnets);
  }
  if(digitalRead(tripSwitch)){
    tripDistance = 0;
  }
}