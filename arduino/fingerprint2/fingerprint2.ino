#include <SoftwareSerial.h>
#include "DFRobotDFPlayerMini.h"

// Use pins 2 and 3 to communicate with DFPlayer Mini
static const uint8_t PIN_MP3_TX = 26; // Connects to module's RX 
static const uint8_t PIN_MP3_RX = 27; // Connects to module's TX 
SoftwareSerial softwareSerial(PIN_MP3_RX, PIN_MP3_TX);

// Create the Player object
DFRobotDFPlayerMini player;

void setup() {

  // Init USB serial port for debugging
  Serial.begin(9600);
  // Init serial port for DFPlayer Mini
  softwareSerial.begin(9600);

  // Start communication with DFPlayer Mini
if (player.begin(softwareSerial, true, false)) {  // Enable debug prints
  Serial.println("Connected to DFPlayer Mini successfully!");
  player.volume(20);
  player.play(1);
} else {
  Serial.println("Failed to initialize DFPlayer Mini.");
}


void loop() {

 
   }