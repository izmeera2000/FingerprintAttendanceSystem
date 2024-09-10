// Define the pin that controls the door lock (e.g., connected to a relay)
#define DOOR_LOCK_PIN 12

void setup() {
  // Initialize serial communication and fingerprint sensor
  Serial.begin(115200);
  mySerial.begin(57600, SERIAL_8N1, 16, 17); // RX and TX for R307
  
  // Initialize WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("Connected to WiFi");

  // Initialize door lock pin (output pin connected to relay)
  pinMode(DOOR_LOCK_PIN, OUTPUT);
  digitalWrite(DOOR_LOCK_PIN, LOW);  // Keep the door locked initially
}

void sendFingerprintToServer(uint8_t* templateData, size_t dataSize) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverURL);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Convert the fingerprint data to a string format
    String templateString = "";
    for (size_t i = 0; i < dataSize; i++) {
      if (templateData[i] < 16) templateString += "0";
      templateString += String(templateData[i], HEX);
    }

    // Prepare the POST data
    String postData = "fingerprint_template=" + templateString;

    // Send the POST request
    int httpResponseCode = http.POST(postData);

    // Check the response from the server
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server Response: " + response);

      // If server says "open", unlock the door
      if (response == "open") {
        Serial.println("Access Granted! Opening the door...");
        digitalWrite(DOOR_LOCK_PIN, HIGH);  // Unlock the door (activate relay)
        delay(5000);  // Keep the door unlocked for 5 seconds
        digitalWrite(DOOR_LOCK_PIN, LOW);   // Lock the door again
      } else {
        Serial.println("Access Denied.");
      }
    } else {
      Serial.println("Error sending POST request: " + String(httpResponseCode));
    }

    http.end();
  } else {
    Serial.println("WiFi disconnected, trying to reconnect...");
  }
}
