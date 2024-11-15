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
  enrollFingerprintTemplate();
  delay(5000); // Delay to prevent repeated posting

}


bool enrollFingerprintTemplate() {
  int id = 1;  // ID for the template
  Serial.println("Place your finger on the sensor...");

  if (finger.getImage() != FINGERPRINT_OK) return false;

  if (finger.createModel() != FINGERPRINT_OK) return false;

  // Load the model into buffer
  if (finger.loadModel(id) != FINGERPRINT_OK) return false;

  // Send template data to ESP32 serial buffer
  if (finger.getModel() == FINGERPRINT_OK) {
    Serial.println("Fingerprint template created successfully.");

    postFingerprintTemplate();
    return true;
  } else {
    Serial.println("Failed to create fingerprint template.");
    return false;
  }
}
void postFingerprintTemplate() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("https://fas.e-veterinar.com/post_fp");

    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Get template data from the sensor
    uint8_t templateData[512]; // Maximum size for a fingerprint template
    int templateLength = finger.getModel(); // Get the template size

    if (templateLength > 0) {
      memcpy(templateData, finger.templateData, templateLength);

      // Convert the template data to a hex string
      String hexTemplate = "";
      for (int i = 0; i < templateLength; i++) {
        hexTemplate += String(templateData[i], HEX);
      }

      // Prepare POST data
      String postData = "post_fp=" + hexTemplate;

      // Send POST request
      int httpResponseCode = http.POST(postData);

      if (httpResponseCode > 0) {
        String response = http.getString();
        Serial.println("Server response: " + response);
      } else {
        Serial.println("Error in POST request");
      }
      http.end();
    } else {
      Serial.println("Error reading fingerprint template.");
    }
  } else {
    Serial.println("WiFi disconnected");
  }
}