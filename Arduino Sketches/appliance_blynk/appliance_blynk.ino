
int ap1 = 50;



#include <BlynkSimpleStream.h>

// You should get Auth Token in the Blynk App.
// Go to the Project Settings (nut icon).
char auth[] = "PTwpSvN-zGoRrFR_WUitQl_7HXb8tEOW";

void setup()
{
  Serial.begin(9600);
  Blynk.begin(Serial, auth);
  pinMode(ap1,OUTPUT);

}



void loop()
{

  Blynk.run();

  
}
