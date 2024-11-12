#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>

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

  // Initialize the fingerprint sensor
  if (finger.verifyPassword()) {
    Serial.println("Fingerprint sensor detected!");
  } else {
    Serial.println("Fingerprint sensor not detected!");
    while (1);
  }
}

void loop() {
  uint8_t id = getFingerprintID();
  if (id == FINGERPRINT_OK) {
    Serial.println("Fingerprint matched");
  } else {
    Serial.println("Fingerprint not matched");
  }
  delay(1000);
}

uint8_t getFingerprintID() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK) {
    return p;
  }

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK) {
    return p;
  }

  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK) {
    return p;
  }

  // Found a match!
  return finger.fingerID;
}
