<?php
// delete-game.php

// Connect to database
include("db.php");

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid game ID.");
}

$id = (int) $_GET['id'];

// Prepare delete query
$stmt = $mysqli->prepare("DELETE FROM videogames WHERE game_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    
    // If called by JavaScript fetch(), return JSON success
    if (isset($_GET['ajax'])) {
        echo json_encode(["status" => "success"]);
        exit;
    }

    // Normal browser delete → redirect back
    header("Location: index.php");
    exit;

} else {
    if (isset($_GET['ajax'])) {
        echo json_encode(["status" => "error"]);
        exit;
    }
    
    echo "Error deleting game.";
}

$stmt->close();
?>
