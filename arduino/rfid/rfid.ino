#define RELAY_PIN 23      // GPIO Pin controlling relay
#define BUTTON_PIN 33      // GPIO Pin for emergency button

void setup() {
  Serial.begin(9600);  // Initialize serial communications with the PC

  pinMode(RELAY_PIN, OUTPUT);    // Set the relay pin as output
  pinMode(BUTTON_PIN, INPUT_PULLUP); // Set the emergency button pin as input
  digitalWrite(RELAY_PIN, LOW);  // Ensure the solenoid is off initially
}

void loop() {
  // Check the state of the emergency button
  bool buttonState = digitalRead(BUTTON_PIN) == LOW;

  if (buttonState) {
    digitalWrite(RELAY_PIN, HIGH); // Activate solenoid when button is pressed
    Serial.println("Emergency Button Pressed: Solenoid Activated");
  } else {
    digitalWrite(RELAY_PIN, LOW);  // Deactivate solenoid when button is not pressed
    Serial.println("Solenoid Deactivated");
  }

  delay(100);  // Debouncing delay
}
