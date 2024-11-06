#include <Adafruit_Fingerprint.h>

HardwareSerial mySerial(2);  // UART2 on GPIO16 (RX) and GPIO17 (TX)
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

// Define GPIO pins for touch sensors
const int touchPin1 = 4;  // Touch pin for Sensor 1 (IN)
const int touchPin2 = 5;  // Touch pin for Sensor 2 (OUT)

void setup() {
  Serial.begin(115200);                       // Debug serial
  mySerial.begin(57600, SERIAL_8N1, 16, 17);  // UART2 for fingerprint sensors

  pinMode(touchPin1, INPUT);
  pinMode(touchPin2, INPUT);
}

void loop() {
  if (digitalRead(touchPin1) == HIGH) {
    Serial.println("Sensor 1 (IN) activated.");
    finger.begin(57600);
    if (finger.verifyPassword()) {
      checkFingerprint("IN");
    } else {
      Serial.println("Sensor 1 not detected.");
    }
  }
  if (digitalRead(touchPin2) == HIGH) {
    Serial.println("Sensor 2 (OUT) activated.");
    finger.begin(57600);
    if (finger.verifyPassword()) {
      checkFingerprint("OUT");
    } else {
      Serial.println("Sensor 2 not detected.");
    }
  }

  delay(100);  // Small delay to debounce touch sensors
}

void checkFingerprint(String action) {
  Serial.print("Place your finger on the ");
  Serial.print(action);
  Serial.println(" sensor...");

  int result = finger.getImage();
  if (result == FINGERPRINT_OK) {
    Serial.print(action);
    Serial.println(" fingerprint image taken");

    result = finger.image2Tz();
    if (result == FINGERPRINT_OK) {
      Serial.print("Fingerprint image converted for ");
      Serial.println(action);
    } else {
      Serial.print(action);
      Serial.println(" fingerprint conversion failed.");
    }
  } else if (result == FINGERPRINT_NOFINGER) {
    Serial.println("No finger detected");
  } else {
    Serial.print("Error on ");
    Serial.print(action);
    Serial.println(" sensor.");
  }
}
