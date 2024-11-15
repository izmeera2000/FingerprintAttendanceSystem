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

    Serial.println(F("Reading sensor parameters"));
  finger.getParameters();
  Serial.print(F("Status: 0x")); Serial.println(finger.status_reg, HEX);
  Serial.print(F("Sys ID: 0x")); Serial.println(finger.system_id, HEX);
  Serial.print(F("Capacity: ")); Serial.println(finger.capacity);
  Serial.print(F("Security level: ")); Serial.println(finger.security_level);
  Serial.print(F("Device address: ")); Serial.println(finger.device_addr, HEX);
  Serial.print(F("Packet len: ")); Serial.println(finger.packet_len);
  Serial.print(F("Baud rate: ")); Serial.println(finger.baud_rate);
}

void loop() {
  getFingerprintEnroll();
  delay(5000); // Delay to prevent repeated posting

}


uint8_t getFingerprintEnroll() {
 int id = 3;
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


// bool enrollFingerprintTemplate() {
//   int id = 1;  // ID for the template
//   Serial.println("Place your finger on the sensor...");

//   if (finger.getImage() != FINGERPRINT_OK) return false;

//   if (finger.createModel() != FINGERPRINT_OK) return false;

//   // Load the model into buffer
//   if (finger.loadModel(id) != FINGERPRINT_OK) return false;

//   // Send template data to ESP32 serial buffer
//   if (finger.getModel() == FINGERPRINT_OK) {
//     Serial.println("Fingerprint template created successfully.");

//     postFingerprintTemplate();
//     return true;
//   } else {
//     Serial.println("Failed to create fingerprint template.");
//     return false;
//   }
// }




// void postFingerprintTemplate() {
//   if (WiFi.status() == WL_CONNECTED) {
//     HTTPClient http;
//     http.begin("https://fas.e-veterinar.com/post_fp");

//     http.addHeader("Content-Type", "application/x-www-form-urlencoded");

//     // Get template data from the sensor
//     uint8_t templateData[512]; // Maximum size for a fingerprint template
//     int templateLength = finger.getModel(); // Get the template size

//     if (templateLength > 0) {
//       memcpy(templateData, finger.templateData, templateLength);

//       // Convert the template data to a hex string
//       String hexTemplate = "";
//       for (int i = 0; i < templateLength; i++) {
//         hexTemplate += String(templateData[i], HEX);
//       }

//       // Prepare POST data
//       String postData = "post_fp=" + hexTemplate;

//       // Send POST request
//       int httpResponseCode = http.POST(postData);

//       if (httpResponseCode > 0) {
//         String response = http.getString();
//         Serial.println("Server response: " + response);
//       } else {
//         Serial.println("Error in POST request");
//       }
//       http.end();
//     } else {
//       Serial.println("Error reading fingerprint template.");
//     }
//   } else {
//     Serial.println("WiFi disconnected");
//   }
// }