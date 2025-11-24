<?php

// Connect to database
include("db.php");

// Make sure ?id= is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid game ID.");
}

$id = (int) $_GET['id']; // cast to int to prevent SQL injection

// Use prepared statements for safety
$stmt = $mysqli->prepare("SELECT game_name, game_desc FROM videogames WHERE game_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if game exists
if ($result->num_rows === 0) {
    die("Game not found.");
}

$a_row = $result->fetch_assoc();
?>

<h1><?= htmlspecialchars($a_row['game_name']) ?></h1>
<p><?= nl2br(htmlspecialchars($a_row['game_desc'])) ?></p>
<a href="index.php">&lt;&lt; Back to list</a>
