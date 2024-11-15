/*
 * This ESP32 code is created by esp32io.com
 *
 * This ESP32 code is released in the public domain
 *
 * For more detail (instruction and wiring diagram), visit https://esp32io.com/tutorials/esp32-solenoid-lock
 */

#define RELAY_PIN 13 // ESP32 pin GPIO16, which connects to the solenoid lock via the relay

// the setup function runs once when you press reset or power the board
void setup() {
  // initialize digital pin  as an output.
  pinMode(RELAY_PIN, OUTPUT);
}

// the loop function runs over and over again forever
void loop() {
  digitalWrite(RELAY_PIN, HIGH); // unlock the door
  delay(5000);
  digitalWrite(RELAY_PIN, LOW);  // lock the door
  delay(5000);
}
