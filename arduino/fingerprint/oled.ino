
void simpleOLED(String message) {
  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0, 10);
  // Display static text
  display.println(message);
  display.display();
}


void initOLED() {

  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {  // Address 0x3D for 128x64
    Serial.println(F("SSD1306 allocation failed"));
    for (;;)
      ;
  }
  delay(100);

  display.clearDisplay();
}







const unsigned char fplogo[] PROGMEM = {
  0x00, 0x00, 0x00, 0x00, 0x00, 0x0f, 0xff, 0xff, 0xff, 0x00, 0x0f, 0xff, 0xff, 0xff, 0x80, 0x19,
  0xff, 0x9f, 0xf9, 0x80, 0x1b, 0xfc, 0xf3, 0xfd, 0x80, 0x1f, 0xf3, 0xfe, 0xff, 0x80, 0x1f, 0xef,
  0xff, 0x7f, 0x80, 0x1f, 0xdf, 0xff, 0xbf, 0x80, 0x1f, 0xbf, 0xff, 0xdf, 0x80, 0x1f, 0xbf, 0xff,
  0xff, 0x80, 0x1f, 0x7f, 0xff, 0xef, 0x80, 0x1f, 0x7f, 0xff, 0xff, 0x80, 0x1f, 0xff, 0xff, 0xff,
  0x80, 0x1f, 0xff, 0xff, 0xff, 0x80, 0x1f, 0xff, 0xff, 0xff, 0x80, 0x1f, 0xff, 0xff, 0xff, 0x80,
  0x1e, 0xff, 0xff, 0xf7, 0x80, 0x1b, 0xff, 0xff, 0xf7, 0xc0, 0x1e, 0xff, 0xff, 0xf7, 0x80, 0x1f,
  0xff, 0xff, 0xff, 0x80, 0x1f, 0xff, 0xff, 0xff, 0x80, 0x1f, 0xff, 0xff, 0xff, 0x80, 0x1f, 0xff,
  0xff, 0xff, 0x80, 0x1f, 0x7f, 0xff, 0xff, 0x80, 0x1f, 0x7f, 0xff, 0xff, 0x80, 0x1f, 0x7f, 0xff,
  0xef, 0x80, 0x1f, 0xbf, 0xff, 0xdf, 0x80, 0x1f, 0xff, 0xff, 0xff, 0x80, 0x1f, 0xcf, 0xff, 0xbf,
  0x80, 0x1f, 0xef, 0xff, 0x7f, 0x80, 0x1b, 0xf9, 0xfd, 0xfd, 0x80, 0x19, 0xfc, 0xf7, 0xfd, 0x80,
  0x1d, 0xff, 0x9f, 0xfb, 0x80, 0x0f, 0xff, 0xff, 0xff, 0x00, 0x07, 0x9f, 0x67, 0xde, 0x00, 0x00,
  0x00, 0x00, 0x00, 0x00
};


void OLEDwithFP(String message) {
  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0, 10);
  // Display static text
  display.println(message);
  display.drawBitmap(28, 20, fplogo, 36, 36, WHITE);  // Adjust the size if needed

  display.display();
}

