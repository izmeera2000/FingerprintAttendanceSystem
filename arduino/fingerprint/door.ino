void OpenDoor() {
    // Read the sensor state

  int state = digitalRead(IR_PIN);

  if (state != LOW) {
    Serial.println("The obstacle is present");
    digitalWrite(RELAY_PIN, HIGH);  // unlock the door
  } 
}


void CloseDoor() {
    // Read the sensor state

  int state = digitalRead(IR_PIN);

  if (state == LOW) {
    Serial.println("The obstacle is present");
    digitalWrite(RELAY_PIN, HIGH);  // unlock the door
  } 
}