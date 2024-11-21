#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <WiFi.h>
#include "DFRobotDFPlayerMini.h"
#include <Wire.h>
#include <HTTPClient.h>
#include <HardwareSerial.h>


const char* ssid = "NoName";
const char* password = "54548484";
const char* fp_name_in = "testin";
const char* fp_name_out = "testout";
// Define software serial pins
#define RX_PIN 18
#define TX_PIN 5
#define TOUCH2 2

#define RXfp1_PIN 16
#define TXfp1_PIN 17
#define TOUCH1 4

#define RX2_PIN 12
#define TX2_PIN 14

#define IR_PIN 34     // ESP32 pin GPIO18 connected to OUT pin of IR obstacle avoidance sensor
#define RELAY_PIN 13  // ESP32 pin GPIO16, which connects to the solenoid lock via the relay


// Create SoftwareSerial object
HardwareSerial mySerialfp(2);  // Use UART2 (index 2)
SoftwareSerial mySerial(RX_PIN, TX_PIN);
SoftwareSerial DFPSerial(RX2_PIN, TX2_PIN);

// Initialize the fingerprint sensor
DFRobotDFPlayerMini player;

Adafruit_Fingerprint finger2 = Adafruit_Fingerprint(&mySerial);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerialfp);

int loginmode = 1;

void setup() {
  Serial.begin(115200);
  mySerial.begin(57600);
  DFPSerial.begin(9600);
  mySerialfp.begin(57600, SERIAL_8N1, RXfp1_PIN, TXfp1_PIN);

  // Wait for serial to initialize
  while (!Serial)
    ;

  // WiFi.begin(ssid, password);
  // while (WiFi.status() != WL_CONNECTED) {
  //   delay(1000);
  //   Serial.println("Connecting to WiFi...");
  // }
  // Serial.println("Connected to WiFi");


  // Initialize the fingerprint sensor
  if (finger2.verifyPassword()) {
    Serial.println("Fingerprint sftwr sensor detected!");
  } else {
    Serial.println("Fingerprint sftwr sensor not detected!");
    while (1)
      ;
  }

  if (finger.verifyPassword()) {
    Serial.println("Fingerprint hrdwr detected!");
  } else {
    Serial.println("Fingerprint hrdwr sensor not detected!");
    while (1)
      ;
  }

  if (player.begin(DFPSerial)) {
    Serial.println("OK");

    // Set volume to maximum (0 to 30).
    player.volume(10);
    // Play the first MP3 file on the SD card
    player.play(1);
  } else {
    Serial.println("Connecting to DFPlayer Mini failed!");
  }

  // Serial.println(F("Reading sensor parameters"));
  // finger.getParameters();
  // Serial.print(F("Status: 0x"));
  // Serial.println(finger.status_reg, HEX);
  // Serial.print(F("Sys ID: 0x"));
  // Serial.println(finger.system_id, HEX);
  // Serial.print(F("Capacity: "));
  // Serial.println(finger.capacity);
  // Serial.print(F("Security level: "));
  // Serial.println(finger.security_level);
  // Serial.print(F("Device address: "));
  // Serial.println(finger.device_addr, HEX);
  // Serial.print(F("Packet len: "));
  // Serial.println(finger.packet_len);
  // Serial.print(F("Baud rate: "));
  // Serial.println(finger.baud_rate);

  finger2.getTemplateCount();

  if (finger2.templateCount == 0) {
    Serial.print("Sensor  2 doesn't contain any fingerprint data. Please run the 'enroll' example.");
  } else {
    Serial.println("Waiting for valid finger...");
    Serial.print("Sensor 2 contains ");
    Serial.print(finger2.templateCount);
    Serial.println(" templates");
  }


  finger.getTemplateCount();

  if (finger.templateCount == 0) {
    Serial.print("Sensor  1 doesn't contain any fingerprint data. Please run the 'enroll' example.");
  } else {
    Serial.println("Waiting for valid finger...");
    Serial.print("Sensor 1 contains ");
    Serial.print(finger.templateCount);
    Serial.println(" templates");
  }



  pinMode(IR_PIN, INPUT);
  pinMode(RELAY_PIN, OUTPUT);
  pinMode(TOUCH1, INPUT);
  pinMode(TOUCH2, INPUT);
}

void loop() {


  int id = 8;

  if (choice == '1') {
  enrollFinger(id);
  } else if (choice == '2') {
    Serial.println("Enter Finger ID to Transfer:");
    while (!Serial.available());
    int id = Serial.parseInt();
    transferFingerprintTemplate(id);
  } else {
    Serial.println("Invalid choice.");
  }

  transferFingerprintTemplate(id);
}



uint8_t enrollFinger(uint16_t id) {
    int p = -1;
  Serial.print("Waiting for valid finger to enroll as #"); Serial.println(id);
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image taken");
      break;
    case FINGERPRINT_NOFINGER:
      Serial.print(".");
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      break;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Imaging error");
      break;
    default:
      Serial.println("Unknown error");
      break;
    }
  }

  // OK success!

  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  Serial.println("Remove finger");
  delay(2000);
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  Serial.print("ID "); Serial.println(id);
  p = -1;
  Serial.println("Place same finger again");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image taken");
      break;
    case FINGERPRINT_NOFINGER:
      Serial.print(".");
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      break;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Imaging error");
      break;
    default:
      Serial.println("Unknown error");
      break;
    }
  }

  // OK success!

  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK converted!
  Serial.print("Creating model for #");  Serial.println(id);

  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    Serial.println("Prints matched!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Fingerprints did not match");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  Serial.print("ID "); Serial.println(id);
  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    Serial.println("Stored!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not store in that location");
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  return true;
}

uint8_t downloadFingerprintTemplate(uint16_t id, uint8_t* fingerTemplate) {
    Serial.println("Downloading");

  uint8_t p = finger.loadModel(id);
  if (p != FINGERPRINT_OK) return p;

  p = finger.getModel();
  if (p != FINGERPRINT_OK) return p;

  // Read template data
  uint8_t bytesReceived[534];
  memset(bytesReceived, 0xff, 534);
  uint32_t starttime = millis();
  int i = 0;
  while (i < 534 && (millis() - starttime) < 20000) {
    if (mySerial.available()) {
      bytesReceived[i++] = mySerial.read();
    }
  }

  if (i != 534) return FINGERPRINT_PACKETRECIEVEERR;

  // Filter the data packets
  memcpy(fingerTemplate, bytesReceived + 9, 256);
  memcpy(fingerTemplate + 256, bytesReceived + 9 + 256 + 2 + 9, 256);
  return FINGERPRINT_OK;
}

uint8_t uploadFingerprintTemplate(uint16_t id, uint8_t* fingerTemplate) {
    Serial.println("uploading");

  uint8_t packet[] = {
    0xEF, 0x01, 0xFF, 0xFF, 0xFF, 0xFF, 0x01, 0x00, 0x04, 0x07, (uint8_t)(id >> 8), (uint8_t)(id & 0xFF), 0x00
  };
  packet[11] = 0x07 + (id >> 8) + (id & 0xFF);

  // Send the packet to the second fingerprint sensor
  mySerial.write(packet, sizeof(packet));

  // Wait for acknowledgment
  uint8_t ack[12];
  int ackLen = 0;
  uint32_t starttime = millis();
  while ((millis() - starttime) < 2000 && ackLen < sizeof(ack)) {
    if (mySerial.available()) {
      ack[ackLen++] = mySerial.read();
    }
  }
  if (ackLen != 12 || ack[6] != 0x00) return FINGERPRINT_PACKETRECIEVEERR;

  // Upload first 256 bytes
  uint8_t dataPacket[267] = { 0xEF, 0x01, 0xFF, 0xFF, 0xFF, 0xFF, 0x02, 0x01, 0x00, 0xA0 };
  memcpy(dataPacket + 10, fingerTemplate, 256);
  mySerial.write(dataPacket, sizeof(dataPacket));

  // Upload second 256 bytes
  dataPacket[7] = 0x02;
  memcpy(dataPacket + 10, fingerTemplate + 256, 256);
  mySerial.write(dataPacket, sizeof(dataPacket));

  // Wait for acknowledgment
  ackLen = 0;
  starttime = millis();
  while ((millis() - starttime) < 2000 && ackLen < sizeof(ack)) {
    if (mySerial.available()) {
      ack[ackLen++] = mySerial.read();
    }
  }

  return (ackLen == 12 && ack[6] == 0x00) ? FINGERPRINT_OK : FINGERPRINT_PACKETRECIEVEERR;
}


uint8_t transferFingerprintTemplate(uint16_t id) {
    Serial.println("Transferring");

  uint8_t fingerTemplate[512];
   downloadFingerprintTemplate(id, fingerTemplate);
  // if (result != FINGERPRINT_OK) {
  //   Serial.println("Failed to download template.");
  //   return result;
  // }

 uploadFingerprintTemplate(id, fingerTemplate);
  // if (result != FINGERPRINT_OK) {
  //   Serial.println("Failed to upload template to second sensor.");
  //   return result;
  // }

  Serial.println("Template successfully transferred!");
  return FINGERPRINT_OK;
}
