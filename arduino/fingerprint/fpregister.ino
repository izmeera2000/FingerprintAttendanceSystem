uint8_t getFingerprintEnroll(int id) {
  int p = -1;
  bool success = false;

  while (!success) {
    Serial.print("Waiting 1 for valid finger to enroll as #");

    Serial.println(id);

    simpleOLED("Please Place Finger On OUT");

    // Step 1: Capture the image
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

    // Step 2: Convert the image to template
    p = finger.image2Tz(1);
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image converted");
        break;
      case FINGERPRINT_IMAGEMESS:
        Serial.println("Image too messy");
        continue;  // Retry the whole process if the image is messy
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        continue;  // Retry the whole process on communication error
      case FINGERPRINT_FEATUREFAIL:
      case FINGERPRINT_INVALIDIMAGE:
        Serial.println("Could not find fingerprint features");
        continue;  // Retry if the features can't be found
      default:
        Serial.println("Unknown error");
        continue;  // Retry on unknown error
    }
    simpleOLED("Remove finger");

    Serial.println("Remove finger");
    delay(2000);

    // Step 3: Wait for finger removal
    p = 0;
    while (p != FINGERPRINT_NOFINGER) {
      p = finger.getImage();
    }

    Serial.print("ID ");
    Serial.println(id);
    p = -1;
    Serial.println("Place same finger again");
    simpleOLED("Place same finger again");

    // Step 4: Capture the same finger again
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

    // Step 5: Convert the second image to template
    p = finger.image2Tz(2);
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image converted");
        break;
      case FINGERPRINT_IMAGEMESS:
        Serial.println("Image too messy");
        continue;  // Retry the whole process if the image is messy
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        continue;  // Retry the whole process on communication error
      case FINGERPRINT_FEATUREFAIL:
      case FINGERPRINT_INVALIDIMAGE:
        Serial.println("Could not find fingerprint features");
        continue;  // Retry if the features can't be found
      default:
        Serial.println("Unknown error");
        continue;  // Retry on unknown error
    }
    simpleOLED("Creating model");

    // Step 6: Create model
    Serial.print("Creating model for #");
    Serial.println(id);
    p = finger.createModel();
    if (p == FINGERPRINT_OK) {
      Serial.println("Prints matched!");
    } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
      Serial.println("Communication error");
      continue;  // Retry the whole process on communication error
    } else if (p == FINGERPRINT_ENROLLMISMATCH) {
      Serial.println("Fingerprints did not match");
      continue;  // Retry the whole process if fingerprints didn't match
    } else {
      Serial.println("Unknown error");
      continue;  // Retry on unknown error
    }

    // Step 7: Store model in fingerprint sensor
    Serial.print("ID ");
    Serial.println(id);
    p = finger.storeModel(id);
    if (p == FINGERPRINT_OK) {
      Serial.println("Stored!");
      simpleOLED("Stored");

      success = true;  // If successful, exit the loop
    } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
      Serial.println("Communication error");
      continue;  // Retry the whole process on communication error
    } else if (p == FINGERPRINT_BADLOCATION) {
      Serial.println("Could not store in that location");
      continue;  // Retry if storage location is bad
    } else if (p == FINGERPRINT_FLASHERR) {
      Serial.println("Error writing to flash");
      continue;  // Retry on flash error
    } else {
      Serial.println("Unknown error");
      continue;  // Retry on unknown error
    }
  }
  return true;  // Return success when the process is completed
}

uint8_t getFingerprintEnroll2(int id) {
  int p = -1;
  bool success = false;

  while (!success) {
    Serial.print("Waiting  2 for valid finger to enroll as #");
    Serial.println(id);
    simpleOLED("Please Place Finger On OUT");

    // Step 1: Capture the image
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

    // Step 2: Convert the image to template
    p = finger2.image2Tz(1);
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image converted");
        break;
      case FINGERPRINT_IMAGEMESS:
        Serial.println("Image too messy");
        continue;  // Retry the whole process if the image is messy
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        continue;  // Retry the whole process on communication error
      case FINGERPRINT_FEATUREFAIL:
      case FINGERPRINT_INVALIDIMAGE:
        Serial.println("Could not find fingerprint features");
        continue;  // Retry if the features can't be found
      default:
        Serial.println("Unknown error");
        continue;  // Retry on unknown error
    }

    Serial.println("Remove finger");
    delay(2000);
    simpleOLED("Remove finger");

    // Step 3: Wait for finger removal
    p = 0;
    while (p != FINGERPRINT_NOFINGER) {
      p = finger2.getImage();
    }

    Serial.print("ID ");
    Serial.println(id);
    p = -1;
    Serial.println("Place same finger again");

    // Step 4: Capture the same finger again
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

    // Step 5: Convert the second image to template
    p = finger2.image2Tz(2);
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image converted");
        break;
      case FINGERPRINT_IMAGEMESS:
        Serial.println("Image too messy");
        continue;  // Retry the whole process if the image is messy
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        continue;  // Retry the whole process on communication error
      case FINGERPRINT_FEATUREFAIL:
      case FINGERPRINT_INVALIDIMAGE:
        Serial.println("Could not find fingerprint features");
        continue;  // Retry if the features can't be found
      default:
        Serial.println("Unknown error");
        continue;  // Retry on unknown error
    }

    // Step 6: Create model
    Serial.print("Creating model for #");
    Serial.println(id);
    simpleOLED("Creating model");

    p = finger2.createModel();
    if (p == FINGERPRINT_OK) {
      Serial.println("Prints matched!");
    } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
      Serial.println("Communication error");
      continue;  // Retry the whole process on communication error
    } else if (p == FINGERPRINT_ENROLLMISMATCH) {
      Serial.println("Fingerprints did not match");
      continue;  // Retry the whole process if fingerprints didn't match
    } else {
      Serial.println("Unknown error");
      continue;  // Retry on unknown error
    }

    // Step 7: Store model in fingerprint sensor
    Serial.print("ID ");
    Serial.println(id);
    p = finger2.storeModel(id);
    if (p == FINGERPRINT_OK) {
      Serial.println("Stored!");
      simpleOLED("Stored!");

      success = true;  // If successful, exit the loop
    } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
      Serial.println("Communication error");
      continue;  // Retry the whole process on communication error
    } else if (p == FINGERPRINT_BADLOCATION) {
      Serial.println("Could not store in that location");
      continue;  // Retry if storage location is bad
    } else if (p == FINGERPRINT_FLASHERR) {
      Serial.println("Error writing to flash");
      continue;  // Retry on flash error
    } else {
      Serial.println("Unknown error");
      continue;  // Retry on unknown error
    }
  }
  return true;  // Return success when the process is completed
}






void postFingerprintID(int id) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("https://fast.e-veterinar.com/post_fp");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare POST data (convert id to string)
    String postData = "post_fp=" + String(id) + "&fp=" + String(id);

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



int postGETID() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("https://fast.e-veterinar.com/post_fp2");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare POST data (convert id to string)
    String postData = "post_fp2=getid";

    Serial.println("Posting data: ");
    Serial.println(postData);

    // Send POST request
    int httpResponseCode = http.POST(postData);  // Use .c_str() to convert String to const char*

    // Handle the response
    if (httpResponseCode > 0) {
      String response = http.getString();
      // Serial.println("GOTTEN ID : " + response);
      simpleOLED("ID :" + response);

      return response.toInt();
    } else {
      Serial.print("Error in POST request, HTTP code: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi is not connected");
  }
}

void registerFP() {
  simpleOLED("Mode Register");
  delay(100);  // Small delay to debounce (adjust as needed)


  if (!hasRun) {
    int id = postGETID();
    if (id > 0) {



      int test2 = getFingerprintEnroll(id);

      if (test2) {
        int test3 = getFingerprintEnroll2(id);

        if (test3) {
          postFingerprintID(id);
          hasRun = true;  // Set the flag to true after execution
        }
      }
    } else {

      simpleOLED("No ID To Register");
    }
  }
}