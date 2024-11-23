
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

  logFingerprintID(finger.fingerID);
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

  logFingerprintID(finger2.fingerID);
  return finger2.fingerID;
}




void logFingerprintID(int id) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("https://fast.e-veterinar.com/login_fp");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare POST data (convert id to string)
    String postData = "login_fp=" + String(id) + "&fp=" + String(id);

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
