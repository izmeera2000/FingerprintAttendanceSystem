#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "your_SSID";
const char* password = "your_PASSWORD";
// Define software serial pins
#define RX_PIN 18
#define TX_PIN 5

// Create SoftwareSerial object
SoftwareSerial mySerial(RX_PIN, TX_PIN);

// Initialize the fingerprint sensor
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

void setup() {
  Serial.begin(115200);
  mySerial.begin(57600);

  // Wait for serial to initialize
  while (!Serial);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");


  // Initialize the fingerprint sensor
  if (finger.verifyPassword()) {
    Serial.println("Fingerprint sensor detected!");
  } else {
    Serial.println("Fingerprint sensor not detected!");
    while (1);
  }
}

void loop() {
  enrollAndPostFingerprint();

}



void enrollAndPostFingerprint() {
  int id = 1;
  Serial.print("Enrolling fingerprint ID "); Serial.println(id);

  Serial.println("Place your finger on the sensor...");
  while (finger.getImage() != FINGERPRINT_OK);

  Serial.println("Image taken. Removing finger...");
  delay(1000);
  while (finger.getImage() != FINGERPRINT_NOFINGER);

  Serial.println("Place the same finger again...");
  while (finger.getImage() != FINGERPRINT_OK);

  if (finger.createModel() == FINGERPRINT_OK) {
    Serial.println("Fingerprint template created.");

    if (finger.storeModel(id) == FINGERPRINT_OK) {
      Serial.println("Fingerprint template stored successfully.");

      // Post fingerprint data
      postFingerprint(id);
    } else {
      Serial.println("Failed to store fingerprint template.");
    }
  } else {
    Serial.println("Failed to create fingerprint template.");
  }
}

void postFingerprint(int id) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("http://fas.e-veterinar.com/api_endpoint"); // Replace with actual endpoint

    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare data to send
    String postData = "post_fp=" + String(id);

    // Send POST request
    int httpResponseCode = http.POST(postData);

    // Check response
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server response: " + response);
    } else {
      Serial.println("Error in POST request");
    }
    http.end();
      delay(1000); // Delay to prevent repeated posting

  } else {
    Serial.println("WiFi disconnected");
  }
}