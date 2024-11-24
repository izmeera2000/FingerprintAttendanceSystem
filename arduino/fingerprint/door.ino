
bool Check1UserDoor() {
  simpleOLED("Only 1 user allowed");

  unsigned long startTime = millis();
  bool userPassed = false;

  while (millis() - startTime < 10000) {  // 10 seconds timeout
    int state = digitalRead(IR_PIN);

    if (state == LOW && !userPassed) {  // Detect start of user passing
      delay(50);                        // Small debounce delay
      if (digitalRead(IR_PIN) == HIGH) {  // Confirm HIGH state persists
        userPassed = true;
        Serial.println("User Passed");
        delay(200);  // Prevent multiple triggers during passage
        break;       // Exit loop after detecting a user
      }
    }
  }

  if (!userPassed) {
    Serial.println("No user passed, please close the door");
  }
  return userPassed;
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


bool Checkpeople() {
  int state = digitalRead(IR_PIN);
  if (state == LOW) {

    return false;
  } else {
    Serial.println("Checking Door State");

    return true;
  }
}