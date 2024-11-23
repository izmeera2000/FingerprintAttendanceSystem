void emptyDBFP(){
      simpleOLED("Database Emptied");

    finger.emptyDatabase();

    Serial.println("Now database is empty :)");

    finger2.emptyDatabase();
    Serial.println("Now database2  is empty :)");

}