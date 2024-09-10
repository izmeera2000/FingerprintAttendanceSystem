<?php
// Connect to MySQL database
$conn = new mysqli("hostname", "username", "password", "database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the fingerprint template sent by ESP32
$fingerprintTemplate = $_POST['fingerprint_template'];

// Query to check if the fingerprint exists in the database
$sql = "SELECT * FROM fingerprints WHERE template = ?  ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fingerprintTemplate);
$stmt->execute();
$result = $stmt->get_result();

// Check if a match is found
if ($result->num_rows > 0) {
    // If fingerprint matches, return a command to open the door
    echo "open";
} else {
    // If no match, deny access
    echo "deny";
}

$stmt->close();
$conn->close();
?>



