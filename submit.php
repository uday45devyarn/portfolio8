<?php

header('Content-Type: text/plain'); // prevent HTML output


// Load mail function
require_once 'sendMail.php';

// 1. Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "portfolio_db";

$conn = new mysqli($servername, $username, $password, $database);

// 2. Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed.";
    exit;
}

// 3. Collect data safely
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// 4. Insert data into table
$sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    // ✅ Call reusable function
    if (sendMail($name, $email, $subject, $message)) {
        echo "✅ Thanks for contacting me! Your message has been sent.";
    } else {
        echo "⚠️ Message saved but email could not be sent.";
    }
} else {
    http_response_code(500);
    echo "Failed to send message: " . $stmt->error;
}

$stmt->close();
$conn->close();

