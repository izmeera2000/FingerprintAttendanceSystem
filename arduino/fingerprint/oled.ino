
void simpleOLED(String message) {
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0, 10);
  // Display static text
  display.println(message);
  display.display();
}
