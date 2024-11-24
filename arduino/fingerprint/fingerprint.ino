#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <WiFi.h>
#include "DFRobotDFPlayerMini.h"
#include <Wire.h>
#include <HTTPClient.h>
#include <HardwareSerial.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>

const char* ssid = "NoName";
const char* password = "54548484";
const char* fp_name_in = "testin";
const char* fp_name_out = "testout";
String test;
// Define software serial pins
#define RX_PIN 18
#define TX_PIN 5
#define TOUCH2 2

#define RXfp1_PIN 16
#define TXfp1_PIN 17
#define TOUCH1 4

#define RX2_PIN 27
#define TX2_PIN 26

#define IR_PIN 34     // ESP32 pin GPIO18 connected to OUT pin of IR obstacle avoidance sensor
#define RELAY_PIN 13  // ESP32 pin GPIO16, which connects to the solenoid lock via the relay

#define SCREEN_WIDTH 128  // OLED display width, in pixels
#define SCREEN_HEIGHT 64  // OLED display height, in pixels


Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);


// Create SoftwareSerial object
HardwareSerial mySerialfp(2);  // Use UART2 (index 2)
SoftwareSerial mySerial(RX_PIN, TX_PIN);
// SoftwareSerial DFPSerial(RX2_PIN, TX2_PIN);

// Initialize the fingerprint sensor
// DFRobotDFPlayerMini player;

Adafruit_Fingerprint finger2 = Adafruit_Fingerprint(&mySerial);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerialfp);
bool hasRun = false;  // Flag to ensure the block runs only once


void setup() {
  Serial.begin(115200);
  mySerial.begin(57600);
  // DFPSerial.begin(9600);
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

  // while (!player.begin(DFPSerial)) {
  //   Serial.println("Failed to connect to DFPlayer Mini. Retrying in 1 second...");
  //   delay(1000);  // Wait 1 second before retrying
  // }

  // Serial.println("Connected to DFPlayer Mini!");

  // // Set the volume to a reasonable level (0-30)
  // player.volume(20);

  // int fileCount = player.readFileCounts();  // Read number of files
  // Serial.print("Files found on SD card: ");
  // Serial.println(fileCount);

  // if (fileCount > 0) {
  //   Serial.println("Playing the first file...");
  //   player.play(1);  // Play the first MP3 file (0001.mp3)
  // } else {
  //   Serial.println("No MP3 files found on SD card!");
  // }

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
  delay(100);  // Small delay to debounce (adjust as needed)


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
  pinMode(TOUCH1, INPUT);  // Internal pull-up resistor
  pinMode(TOUCH2, INPUT);  // Internal pull-down resistor (if required)
  CloseDoor();
  test = getFingerprintmode("testout");
  Serial.println(test);



  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {  // Address 0x3D for 128x64
    Serial.println(F("SSD1306 allocation failed"));
    for (;;)
      ;
  }
  delay(100);

  display.clearDisplay();
  delay(100);
}

void loop() {
  if (test == "login") {



    loginFP();
    // Serial.println("TOUCH SENSOR 2 activated");
    // }
  } else if (test == "emptydb") {
    emptyDBFP();
  }


  else {

    registerFP();
  }
  delay(100);  // Small delay to debounce (adjust as needed)




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
