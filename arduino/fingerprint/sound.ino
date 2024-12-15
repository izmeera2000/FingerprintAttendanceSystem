void playSound(int order, int vol) {
  player.volume(vol); // Set the volume level

  int maxRetries = 5; // Max retries before giving up
  int retries = 0;
  bool success = false;

  while (retries < maxRetries && !success) {
    player.playFolder(order, 1); // Attempt to play the file in folder `order`
    delay(100); // Small delay before checking if it played successfully

    if (player.available()) {
      int currentState = player.readType(); // Check if player is in 'playing' state

      // Check if the player is currently playing the file
      if (currentState == DFPlayerMini::PLAYING) {
        success = true;
        Serial.println("File is playing successfully.");
      }
    }

    if (!success) {
      retries++;
      Serial.print("Retrying... Attempt ");
      Serial.println(retries);
      delay(1000); // Delay between retries
    }
  }

  if (!success) {
    Serial.println("Failed to play file after maximum retries.");
  }
}
