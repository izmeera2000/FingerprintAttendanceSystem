#include <Wire.h>


void setup() {

Serial.begin(115200);

pinMode(IR_SENSOR_PIN, INPUT);

}

void loop() {

int sensorValue = analogRead(26);

float distance = sensorValue / 9.766; //convert sensor value to distance

Serial.print("Distance:");

Serial.println(distance);

delay(1000);

}