#include <WiFi.h>
#include <HTTPClient.h>
#include <Adafruit_Fingerprint.h>

// Your WiFi credentials
const char* ssid = "your-ssid";
const char* password = "your-password";

// Your server URL (for fingerprint registration)
const char* serverURL = "http://your-server.com/register_fingerprint.php";

// Initialize the fingerprint sensor on hardware serial port 2
HardwareSerial mySerial(2);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

// User ID to associate with the fingerprint
int userID = 1;  // For example, this could be dynamically assigned based on your application

void setup() {
  Serial.begin(115200);
  mySerial.begin(57600, SERIAL_8N1, 16, 17);  // RX and TX pin connections for R307

  // Initialize WiFi connection
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("Connected to WiFi");

  // Initialize the fingerprint sensor
  if (finger.begin()) {
    Serial.println("Fingerprint sensor found!");
  } else {
    Serial.println("Could not find fingerprint sensor :(");
    while (1);
  }

  // Verify the fingerprint sensor password
  if (finger.verifyPassword()) {
    Serial.println("Fingerprint sensor ready.");
  } else {
    Serial.println("Did not find fingerprint sensor :(");
    while (1);
  }
}

void loop() {
  // Prompt to place finger for registration
  Serial.println("Place finger on sensor to register");

  // Wait for the finger to be placed
  int result = finger.getImage();
  if (result != FINGERPRINT_OK) {
    Serial.println("Failed to read fingerprint, try again.");
    delay(1000);
    return;
  }

  // Convert the image to a fingerprint template
  result = finger.image2Tz();
  if (result != FINGERPRINT_OK) {
    Serial.println("Failed to convert image to template, try again.");
    delay(1000);
    return;
  }

  // Store the fingerprint template
  if (finger.storeModel(1) != FINGERPRINT_OK) {
    Serial.println("Failed to store template, try again.");
    delay(1000);
    return;
  }

  // Get the fingerprint template to send to the server
  uint8_t fingerprintTemplate[512];  // 512-byte template size for R307
  finger.getModel(1, fingerprintTemplate);

  // Send the template to the server for registration
  registerFingerprintToServer(fingerprintTemplate, 512, userID);

  delay(5000);  // Wait for 5 seconds before next loop
}

// Function to send the fingerprint template to the server
void registerFingerprintToServer(uint8_t* templateData, size_t dataSize, int userID) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverURL);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Convert the fingerprint data to a string format for transmission
    String templateString = "";
    for (size_t i = 0; i < dataSize; i++) {
      if (templateData[i] < 16) templateString += "0";  // Ensure two-digit HEX format
      templateString += String(templateData[i], HEX);
    }

    // Prepare the POST data (send both user ID and fingerprint template)
    String postData = "fingerprint_template=" + templateString + "&user_id=" + String(userID);

    // Send the POST request
    int httpResponseCode = http.POST(postData);

    // Check the response from the server
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server Response: " + response);
    } else {
      Serial.println("Error sending POST request: " + String(httpResponseCode));
    }

    http.end();
  } else {
    Serial.println("WiFi disconnected, trying to reconnect...");
  }
}
