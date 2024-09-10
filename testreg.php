<?php
// Connect to the MySQL database
$conn = new mysqli("hostname", "username", "password", "database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the fingerprint template and user ID from the POST request
$fingerprintTemplate = $_POST['fingerprint_template'];
$userId = $_POST['user_id'];

// Prepare an SQL query to insert the fingerprint data
$sql = "INSERT INTO fingerprints (user_id, template) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// Bind the fingerprint template and user ID to the query
$stmt->bind_param("is", $userId, $fingerprintTemplate);

// Execute the query
if ($stmt->execute()) {
    echo "Fingerprint registered successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
