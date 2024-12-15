
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

  return finger2.fingerID;
}




String logFingerprintID(int id, int ent) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("https://fast.e-veterinar.com/login_fp");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare POST data (convert id to string)
    String postData = "login_fp=" + String(id) + "&entrance=" + String(ent);
    // simpleOLED(postData);

    Serial.println("Posting data: ");
    Serial.println(postData);

    // Send POST request
    int httpResponseCode = http.POST(postData);  // Use .c_str() to convert String to const char*

    // Handle the response
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server response: " + response);

      return response;
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
  OLEDwithFP("Please Place Finger");

  // First fingerprint sensor
  int fingerid = getFingerprintIDez();
  if (fingerid != -1) {  // Check if a valid ID was returned
    OpenDoor();          // Open door for user entry
    playSound(1, 30);

    bool userDetected = Check1UserDoor();
    if (userDetected) {
      logFingerprintID(fingerid, 1);
      // OLEDwithFP("FP Masuk");
      delay(1000);  // Small delay to prevent overlap

      // Log the fingerprint ID with '1' (entry)
      //check selain user masuk
      CloseDoor();  // Close the door if no user detected

    } else {
      CloseDoor();  // Close the door if no user detected
      Serial.println("Door closed after no user passed (entry).");
    }
  }

  delay(100);  // Small delay to prevent overlap

  // Second fingerprint sensor
  int fingerid2 = getFingerprintIDez2();
  if (fingerid2 != -1) {  // Check if a valid ID was returned
    OpenDoor();           // Open door for user exit
    playSound(2, 30);

    bool userDetected = Check1UserDoor();
    if (userDetected) {
      logFingerprintID(fingerid2, 0);  // Log the fingerprint ID with '0' (exit)
      // OLEDwithFP("FP Masuk");
      delay(1000);  // Small delay to prevent overlap

      CloseDoor();  // Close the door if no user detected

    } else {
      CloseDoor();  // Close the door if no user detected
      Serial.println("Door closed after no user passed (exit).");
    }
  }

  delay(100);  // Small delay before function ends
}
