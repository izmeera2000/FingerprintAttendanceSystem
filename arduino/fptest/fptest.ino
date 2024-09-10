#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <WiFi.h>
#include <WiFiManager.h>
#include <HTTPClient.h>
#include <Adafruit_Fingerprint.h>


#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);  


HardwareSerial mySerial(2);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);


#define BUTTON_PIN 4
bool isRegisterMode = true;  


const char* registerURL = "http://your-server.com/register_fingerprint.php";
const char* loginURL = "http://your-server.com/login_fingerprint.php";


unsigned long inactivityTimeout = 180000;
unsigned long lastActivityTime = 0;  


bool oledOn = true;  

void setup() {
  
  Serial.begin(115200);
  
  
  WiFiManager wifiManager;

  
  if (!wifiManager.autoConnect("ESP32_AP", "password")) {
    Serial.println("Failed to connect and hit timeout");
    ESP.restart();  
  }
  
  
  Serial.println("Connected to WiFi!");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  
  mySerial.begin(57600, SERIAL_8N1, 16, 17);  
  if (finger.begin()) {
    Serial.println("Fingerprint sensor found!");
  } else {
    Serial.println("Could not find fingerprint sensor :(");
    while (1);
  }

  
  if (finger.verifyPassword()) {
    Serial.println("Fingerprint sensor ready.");
  } else {
    Serial.println("Could not find fingerprint sensor :(");
    while (1);
  }

  
  pinMode(BUTTON_PIN, INPUT_PULLUP);

  
  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {  
    Serial.println(F("SSD1306 allocation failed"));
    while (1);
  }
  displayMessage("ESP32 Fingerprint");
  lastActivityTime = millis();  
}

void loop() {
  
  if (digitalRead(BUTTON_PIN) == LOW) {
    delay(200);  
    isRegisterMode = !isRegisterMode;  
    if (isRegisterMode) {
      displayMessage("Register Mode");
    } else {
      displayMessage("Login Mode");
    }
    lastActivityTime = millis();  
    delay(500);  
  }

  
  if (isRegisterMode) {
    handleFingerprintRegistration();
  } else {
    handleFingerprintLogin();
  }

  
  if (millis() - lastActivityTime > inactivityTimeout && oledOn) {
    
    display.ssd1306_command(SSD1306_DISPLAYOFF);
    oledOn = false;
    Serial.println("OLED turned off due to inactivity.");
  }

  delay(1000);  
}


void handleFingerprintRegistration() {
  if (!oledOn) {
    wakeOLED();  
  }
  displayMessage("Place finger to register...");
  if (finger.getImage() != FINGERPRINT_OK) {
    displayMessage("Failed to read fingerprint.");
    return;
  }

  if (finger.image2Tz() != FINGERPRINT_OK) {
    displayMessage("Failed to convert fingerprint.");
    return;
  }

  uint8_t fingerprintTemplate[512];
  finger.getModel(1, fingerprintTemplate);

  registerFingerprintToServer(fingerprintTemplate, 512, userID);
  lastActivityTime = millis();  
}


void handleFingerprintLogin() {
  if (!oledOn) {
    wakeOLED();  
  }
  displayMessage("Place finger to login...");
  if (finger.getImage() != FINGERPRINT_OK) {
    displayMessage("Failed to read fingerprint.");
    return;
  }

  if (finger.image2Tz() != FINGERPRINT_OK) {
    displayMessage("Failed to convert fingerprint.");
    return;
  }

  uint8_t fingerprintTemplate[512];
  finger.getModel(1, fingerprintTemplate);

  loginFingerprintToServer(fingerprintTemplate, 512);
  lastActivityTime = millis();  
}


void registerFingerprintToServer(uint8_t* templateData, size_t dataSize, int userID) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(registerURL);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String templateString = convertTemplateToString(templateData, dataSize);
    String postData = "fingerprint_template=" + templateString + "&user_id=" + String(userID);

    int httpResponseCode = http.POST(postData);
    handleHttpResponse(httpResponseCode, http);
  }
}


void loginFingerprintToServer(uint8_t* templateData, size_t dataSize) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(loginURL);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String templateString = convertTemplateToString(templateData, dataSize);
    String postData = "fingerprint_template=" + templateString;

    int httpResponseCode = http.POST(postData);
    handleHttpResponse(httpResponseCode, http);
  }
}


String convertTemplateToString(uint8_t* templateData, size_t dataSize) {
  String templateString = "";
  for (size_t i = 0; i < dataSize; i++) {
    if (templateData[i] < 16) templateString += "0";
    templateString += String(templateData[i], HEX);
  }
  return templateString;
}


void handleHttpResponse(int httpResponseCode, HTTPClient& http) {
  if (httpResponseCode > 0) {
    String response = http.getString();
    displayMessage("Server: " + response);
  } else {
    displayMessage("Error sending request");
  }
  http.end();
}


void displayMessage(String message) {
  if (!oledOn) {
    wakeOLED();  
  }
  display.clearDisplay();
  display.setCursor(0, 10);
  display.println(message);
  display.display();
}


void wakeOLED() {
  display.ssd1306_command(SSD1306_DISPLAYON);  
  oledOn = true;
  Serial.println("OLED turned on.");
}
