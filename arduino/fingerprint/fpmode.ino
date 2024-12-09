String getFingerprintmode(String fp_name) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("https://fast.e-veterinar.com/fp_mode");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Convert the fingerprint template data to a hex string


    // Prepare POST data
    String postData = "fp_mode=" + fp_name + "&fp_name=" + fp_name;

    // Serial.println("posting data  data is :");

    // Serial.println(postData);
    Serial.println("Posting data: ");
    Serial.println(postData);

    // Send POST request
    int httpResponseCode = http.POST(postData);  // Use .c_str() to convert String to const char*

    // Handle the response
    if (httpResponseCode > 0) {
      String response = http.getString();
      // Serial.println("response  data is :");

      // Serial.println(response);
      // Serial.println("thats all");
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