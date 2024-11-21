#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <WiFi.h>
#include "DFRobotDFPlayerMini.h"
#include <Wire.h>
#include <HTTPClient.h>
#include <HardwareSerial.h>


const char* ssid = "NoName?";
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

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");


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

  if (!player.begin(DFPSerial)) {
    Serial.println("DFPlayer Mini not detected!");
    while (true)
      ;
  }
  Serial.println("DFPlayer Mini detected!");

  player.volume(20);  // Set the volume (0 to 30)
  player.play(1);     // Play the first audio file

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


  // int test = getFingerprintEnroll(4);
  // if (test) {
  //   getFingerprintEnroll2(4);
  // }


  // touchAttachInterrupt(TOUCH1, onTouch1, TOUCH_THRESHOLD);
  // touchAttachInterrupt(TOUCH2, onTouch2, TOUCH_THRESHOLD);
}

void loop() {


  if (digitalRead(TOUCH1) == HIGH) {
    Serial.println("TOUCH SENSOR 1");
    getFingerprintIDez();
  }

  if (digitalRead(TOUCH2) == HIGH) {
    Serial.println("TOUCH SENSOR 1");
    getFingerprintIDez2();
  }


  // String registermode = getFingerprintmode(fp_name_out);

  // if (registermode == "0") {

  // }


  // if (loginmode) {
  //   int id = getFingerprintIDez();
  //   downloadFingerprintTemplate2(id);
  // } else {
  //   downloadFingerprintTemplate(3);
  // }


  // int state = digitalRead(IR_PIN);

  // if (state == LOW) {
  //   Serial.println("The obstacle is present");
  //   digitalWrite(RELAY_PIN, HIGH);  // unlock the door
  // } else {
  //   Serial.println("The obstacle is NOT present");
  //   digitalWrite(RELAY_PIN, LOW);  // unlock the door
  // }

  // digitalWrite(RELAY_PIN, HIGH);  // unlock the door
  // delay(5000);
  // digitalWrite(RELAY_PIN, LOW);  // lock the door
  // delay(5000);


  // if object detect for 5 sec continous
  //  it is a door , lock it

  //  if already login finger but 10 sec no object detct
  //  alarm

  // if object detect for 5 sec continous but alr login fingerpirnt
  //  cancel


  // alarm silakan amsuk , bila pintu baru buka

  //alarm kalau ada org tapi 1 fingerprint

  //fp x detect ,



  //register fp , dekat fp out

  //fp settings dekat website



  //fp transfer data to another fp

  // dobule fp
  //test touchsense






  // delay(50);  //don't ned to run this at full speed.
}


uint8_t getFingerprintEnroll(int id) {


  int p = -1;
  Serial.print("Waiting for valid finger to enroll as #");
  Serial.println(id);
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
  Serial.print("ID ");
  Serial.println(id);
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
  Serial.print("Creating model for #");
  Serial.println(id);

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

  Serial.print("ID ");
  Serial.println(id);
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
  // uploadFingerprintToSensor(finger, finger2, id);

  return true;
}
uint8_t getFingerprintEnroll2(int id) {


  int p = -1;
  Serial.print("Waiting for valid finger 2 to enroll as #");
  Serial.println(id);
  while (p != FINGERPRINT_OK) {
    p = finger2.getImage();
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

  p = finger2.image2Tz(1);
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
    p = finger2.getImage();
  }
  Serial.print("ID ");
  Serial.println(id);
  p = -1;
  Serial.println("Place same finger again");
  while (p != FINGERPRINT_OK) {
    p = finger2.getImage();
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

  p = finger2.image2Tz(2);
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
  Serial.print("Creating model for #");
  Serial.println(id);

  p = finger2.createModel();
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

  Serial.print("ID ");
  Serial.println(id);
  p = finger2.storeModel(id);
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
  // uploadFingerprintToSensor(finger, finger2, id);

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




// void postFingerprintTemplate(uint8_t* fp) {
//   if (WiFi.status() == WL_CONNECTED) {
//     HTTPClient http;
//     http.begin("https://fast.e-veterinar.com/post_fp");
//     http.addHeader("Content-Type", "application/x-www-form-urlencoded");

//     // Convert the fingerprint template data to a hex string
//     String hexTemplate = "";
//     for (int i = 0; i < 512; i++) {
//       if (fp[i] < 16) hexTemplate += "0";  // Add leading zero for single hex digits
//       hexTemplate += String(fp[i], HEX);
//     }


//     // Prepare POST data
//     String postData = "post_fp=" + hexTemplate + "fp=" + hexTemplate;

//     Serial.println("posting data  data is :");

//     Serial.println(postData);

//     // Send POST request
//     int httpResponseCode = http.POST(postData);  // Use .c_str() to convert String to const char*

//     // Handle the response
//     if (httpResponseCode > 0) {
//       String response = http.getString();
//       Serial.println("Server response: " + response);
//     } else {
//       Serial.print("Error in POST request, HTTP code: ");
//       Serial.println(httpResponseCode);
//     }

//     http.end();
//   } else {
//     Serial.println("WiFi is not connected");
//   }
// }

void postFingerprintID(int id) {
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




void printHex(int num, int precision) {
  char tmp[16];
  char format[128];

  sprintf(format, "%%.%dX", precision);

  sprintf(tmp, format, num);
  Serial.print(tmp);
}





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

  postFingerprintID(finger.fingerID);
  // return finger.fingerID;
}


int getFingerprintIDez2() {
  uint8_t p = finger2.getImage();
  if (p != FINGERPRINT_OK) return -1;

  p = finger2.image2Tz();
  if (p != FINGERPRINT_OK) return -1;

  p = finger2.fingerFastSearch();
  if (p != FINGERPRINT_OK) return -1;

  // found a match!
  Serial.print("Found ID #");
  Serial.print(finger2.fingerID);
  Serial.print(" with confidence of ");
  Serial.println(finger2.confidence);

  postFingerprintID(finger2.fingerID);
  // return finger.fingerID;
}





String getFingerprintmode(String fp_name) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("https://fast.e-veterinar.com/fp_mode");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Convert the fingerprint template data to a hex string


    // Prepare POST data
    String postData = "fp_mode=" + fp_name + "fp_name=" + fp_name;

    // Serial.println("posting data  data is :");

    // Serial.println(postData);

    // Send POST request
    int httpResponseCode = http.POST(postData);  // Use .c_str() to convert String to const char*

    // Handle the response
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("response  data is :");

      Serial.println(response);
      Serial.println("thats all");
      return response;
    } else {
      Serial.print("Error in POST request, HTTP code: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi is not connected");
  }
}


void onTouch1() {
  Serial.println("Touched 1");
}

void onTouch2() {
  Serial.println("Touched 2");
}