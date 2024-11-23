
int getFingerprintIDez() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK) return -1;

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK) return -1;

  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK) return -1;

  // found a match!
  Serial.print("Found ID #");
  Serial.print(finger.fingerID);
  Serial.print(" with confidence of ");
  Serial.println(finger.confidence);
  simpleOLED("IN ID #" + String(finger.fingerID));

  return finger.fingerID;
}


int getFingerprintIDez2() {
  uint8_t p = finger2.getImage();
  if (p != FINGERPRINT_OK) return -1;

  p = finger2.image2Tz();
  if (p != FINGERPRINT_OK) return -1;

  p = finger2.fingerFastSearch();
  if (p != FINGERPRINT_OK) return -1;

  // found a match!
  Serial.print("Found 2 ID #");
  Serial.print(finger2.fingerID);
  Serial.print(" with confidence of ");
  Serial.println(finger2.confidence);
  simpleOLED("OUT ID #" + String(finger2.fingerID));

  return true;
}




void logFingerprintID(int id, int ent) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("https://fast.e-veterinar.com/login_fp");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare POST data (convert id to string)
    String postData = "login_fp=" + String(id) + "&entrance=" + String(ent);

    Serial.println("Posting data: ");
    Serial.println(postData);

    // Send POST request
    int httpResponseCode = http.POST(postData);  // Use .c_str() to convert String to const char*

    // Handle the response
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server response: " + response);
    } else {
      Serial.print("Error in POST request, HTTP code: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi is not connected");
  }
}


void loginFP() {

  simpleOLED("Please Place Finger");

  int fingerid = getFingerprintIDez();
  if (fingerid != -1) {             // Check if a valid ID was returned
    logFingerprintID(fingerid, 1);  // Log the fingerprint ID
    OpenDoor();
  }


  // Serial.println("TOUCH SENSOR 1 activated");
  // }
  digitalWrite(RELAY_PIN, HIGH);  // unlock the door

  delay(100);

  // if (digitalRead(TOUCH2) == LOW) {
  int fingerid2 = getFingerprintIDez2();
  if (fingerid2 != -1) {             // Check if a valid ID was returned
    logFingerprintID(fingerid2, 0);  // Log the fingerprint ID
    CloseDoor();
  } 
  delay(100);
}
