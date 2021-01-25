#include <Servo.h>
Servo servo1;
Servo servo2;
#define trigPin 9
#define echoPin 8
long distance;
long duration;
 
void setup() 
{
 pinMode(trigPin, OUTPUT);
 pinMode(echoPin, INPUT);
 Serial.begin(9600);
}
 
void loop() {
  ultra();
  delay(100);
  servo();
}

void servo(){
  if(distance <= 20){
    servo1.attach(7); 
    servo2.attach(5);
    Serial.print("Distance is: ");
    Serial.println(distance);

      servo1.write(180);
      servo2.write(180);
      delay(1000);
      servo1.write(0);
      servo2.write(0);
//      delay(1000);
//      servo1.write(180);
//      servo2.write(180);
//      delay(1000);
//      servo1.write(0);
//      servo2.write(0);
      delay(1000);
  }
  else{
    servo1.detach();
    servo2.detach();
    Serial.print("Far Distance: ");
    Serial.println(distance);
    }
  }
  
void ultra(){
  digitalWrite(trigPin, LOW);
  delayMicroseconds(20);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(100);
  digitalWrite(trigPin, LOW);
  duration = pulseIn(echoPin, HIGH);
  distance = duration*0.034/2;
  }