
void Check1UserDoor() {
  simpleOLED("Only 1 user allowed");

  unsigned long startTime = millis();
  bool userPassed = false;

  while (millis() - startTime < 10000) {  // 10 seconds timeout
    int state = digitalRead(IR_PIN);

    // Detect user passing through
    if (state == LOW && !userPassed) {
      delay(200);                         // Debounce delay to avoid false triggers
      if (digitalRead(IR_PIN) == HIGH) {  // Confirm HIGH state persists (user passed)
        userPassed = true;

        Serial.println("User Passed");
        // delay(2000);  // Message display delay if needed
        break;  // Exit loop once a user passes
      }
    }
  }

  // If no user passed within 10 seconds
  if (!userPassed) {
    Serial.println("No user passed pls close the door");
    CloseDoor();
    // delay(2000);  // Message display delay
  }
}


void OpenDoor() {
  // Read the sensor state
  simpleOLED("Door Unlocked , Please Open");

  // Serial.println("The obstacle is present");
  digitalWrite(RELAY_PIN, HIGH);  // unlock the door
}

void CloseDoor() {
  // Read the sensor state
  simpleOLED("Door Locked");

  digitalWrite(RELAY_PIN, HIGH);  // unlock the door
}

bool CheckDoorState(int sec) {
  int state = digitalRead(IR_PIN);
  Serial.println("Checking Door State");

  unsigned long startTime = millis();
  while (millis() - startTime < sec * 1000) {
    if (state == LOW) {
      return false;
    } else {
      return true;
    }
  }
}