
int flag1 = 0;
int mVperAmp = 100; // use 100 for 20A Module and 66 for 30A Module
const int ap1_s = A0;
double Voltage = 0;
double VRMS = 0;
float AmpsRMS = 0;


void setup() {
  //Serial Begin at 9600 Baud 
  Serial.begin(9600);
  pinMode(A0,INPUT);
}

void loop() {
  
  Voltage = getVPP();
  VRMS = (Voltage/2.0) *0.707;  //root 2 is 0.707
  AmpsRMS = (VRMS * 1000)/mVperAmp;
  
    if (AmpsRMS > 0.1 and flag1 == 0) 
  {
    flag1 = 2;

    Serial.print(AmpsRMS);
    Serial.print(" ");
    Serial.print(flag1);
    Serial.print(" ");
    Serial.println("LED");

  }
  
  else if (AmpsRMS <= 0.1 and flag1 != 0)
  
  {

    flag1 = 0;

    Serial.print(AmpsRMS);
    Serial.print(" ");
    Serial.print(flag1);
    Serial.print(" ");
    Serial.println("LED");
  }

  else if (AmpsRMS >= 0.1 and flag1 != 0)
  {
    flag1 = 1;

    Serial.print(AmpsRMS);
    Serial.print(" ");
    Serial.print(flag1);
    Serial.print(" ");
    Serial.println("LED");
    
  }
}


float getVPP()
{
  float result;
  int readValue;             //value read from the sensor
  int maxValue = 0;          // store max value here
  int minValue = 1023;          // sAore min value here
  
   uint32_t start_time = millis();
   while((millis()-start_time) < 1000) //sample for 1 Sec
   {
       readValue = analogRead(ap1_s);
       // see if you have a new maxValue
       if (readValue > maxValue) 
       {
           /*record the maximum sensor value*/
           maxValue = readValue;
       }
       if (readValue < minValue) 
       {
           /*record the minimum sensor value*/
           minValue = readValue;
       }
   }
   
   // Subtract min from max
   result = ((maxValue - minValue) * 5.0)/1024.0;
      
   return result;
 }
