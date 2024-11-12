#include <SoftwareSerial.h>
#include <Adafruit_Fingerprint.h>

// Define pins for Software Serial (adjust based on your ESP32 model)
#define RX_PIN 18  // Pin for RX (to R307 TX)
#define TX_PIN 5   // Pin for TX (to R307 RX)

// Create SoftwareSerial and Adafruit_Fingerprint objects
EspSoftwareSerial::UART myPort;
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&myPort);

void setup() {
  Serial.begin(115200);  // Start Serial monitor for debug
  myPort.begin(57600, SWSERIAL_8N1, RX_PIN, TX_PIN, false);
  finger.begin(57600);  // Initialize the fingerprint sensor

  // Check if the fingerprint sensor is connected
  if (finger.verifyPassword()) {
    Serial.println("Found fingerprint sensor!");
  } else {
    Serial.println("Did not find fingerprint sensor :(");
    while (1) { delay(1); }
  }
}

void loop() {
  // Example: Get fingerprint ID when a finger is placed
  Serial.println("Place your finger on the sensor");
  int fingerprintID = getFingerprintID();

  if (fingerprintID != -1) {
    Serial.print("Found ID: ");
    Serial.println(fingerprintID);
  } else {
    Serial.println("Fingerprint not recognized.");
  }
  delay(2000);  // Wait a bit before reading again
}

// Function to get fingerprint ID
int getFingerprintID() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK) return -1;

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK) return -1;

  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK) return -1;

  return finger.fingerID;  // Return the found ID
}
