<?php
// Load database credentials from secure location
require_once("/home/stud/0/2432878/db_config.php");


// Enable mysqli exceptions for better security & debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $mysqli->set_charset("utf8mb4"); // Secure charset
} catch (mysqli_sql_exception $e) {
    // Log the exact error to a secure file, not to the webpage
    error_log("DB Connection Error: " . $e->getMessage());

    // Show a generic error to users (no sensitive details)
    die("Database connection failed. Please try again later.");
}
?>
