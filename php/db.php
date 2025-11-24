<?php
// Use environment variables to store sensitive data securely
$servername = getenv('DB_SERVER') ?: 'localhost'; // fallback if env variable not found
$username = getenv('DB_USER') ?: '2432878';
$password = getenv('DB_PASSWORD') ?: 'Santoryu11037';
$dbname = getenv('DB_NAME') ?: 'db2432878';

// Create a new MySQLi object
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check for connection error
if ($mysqli->connect_error) {
    // Log the error instead of showing it to the user
    error_log('MySQL Connection Error (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
    // Display a generic message to the user
    die('There was an issue connecting to the database. Please try again later.');
}

// You can also set a character set for the connection (optional, but good for handling special characters)
$mysqli->set_charset("utf8mb4");

// Example of a secure query using prepared statements:
$stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
if ($stmt === false) {
    error_log('MySQLi Prepare Error: ' . $mysqli->error);
    die('Database query error');
}

$email = 'example@example.com'; // This would come from user input
$stmt->bind_param("s", $email); // Bind email parameter (s = string)

// Execute the prepared statement
$stmt->execute();

// Fetch results securely
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    // Process each row
    echo htmlspecialchars($row['name']); // Sanitize output to prevent XSS
}

// Close the prepared statement and connection
$stmt->close();
$mysqli->close();
?>
