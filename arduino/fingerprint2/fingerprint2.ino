#include <SoftwareSerial.h>
#include "DFRobotDFPlayerMini.h"

// Use pins 2 and 3 to communicate with DFPlayer Mini
static const uint8_t PIN_MP3_TX = 26;  // Connects to module's RX
static const uint8_t PIN_MP3_RX = 27;  // Connects to module's TX
SoftwareSerial softwareSerial(PIN_MP3_RX, PIN_MP3_TX);

// Create the Player object
DFRobotDFPlayerMini player;

void setup() {

  // Init USB serial port for debugging
  Serial.begin(9600);
  // Init serial port for DFPlayer Mini
  softwareSerial.begin(9600);

  // Start communication with DFPlayer Mini
  while (!player.begin(softwareSerial)) {
    Serial.println("Failed to connect to DFPlayer Mini. Retrying in 1 second...");
    delay(1000);  // Wait 1 second before retrying
  }

  Serial.println("Connected to DFPlayer Mini!");

  // Set the volume to a reasonable level (0-30)
  player.volume(20);

    int fileCount = player.readFileCounts();  // Read number of files
    Serial.print("Files found on SD card: ");
    Serial.println(fileCount);

    if (fileCount > 0) {
        Serial.println("Playing the first file...");
        player.play(1); // Play the first MP3 file (0001.mp3)
    } else {
        Serial.println("No MP3 files found on SD card!");
    }
}

void loop() {
}