<?php
// update-game.php

include("db.php");

// 1. VALIDATE ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid game ID.");
}

$id = (int) $_GET['id'];

// 2. LOAD CURRENT DATA
$stmt = $mysqli->prepare("SELECT * FROM videogames WHERE game_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Game not found?
if ($result->num_rows === 0) {
    die("Game not found.");
}

$game = $result->fetch_assoc();

// 3. PROCESS FORM SUBMISSION
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $game_name     = $_POST['game_name'];
    $genre         = $_POST['genre'];
    $rating        = $_POST['rating'];
    $released_date = $_POST['released_date'];
    $game_desc     = $_POST['game_desc'];

    $update = $mysqli->prepare(
        "UPDATE videogames
         SET game_name=?, genre=?, rating=?, released_date=?, game_desc=?
         WHERE game_id=?"
    );

    $update->bind_param(
        "ssissi",
        $game_name,
        $genre,
        $rating,
        $released_date,
        $game_desc,
        $id
    );

    if ($update->execute()) {
        header("Location: index.php?updated=1");
        exit;
    } else {
        echo "Error updating the game.";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Game</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" 
          rel="stylesheet">
</head>

<body class="p-4">

<div class="container">

    <h1 class="mb-4">Update Game</h1>

    <form method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label class="form-label">Game Name</label>
            <input type="text" name="game_name" class="form-control" 
                   value="<?= htmlspecialchars($game['game_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Genre</label>
            <input type="text" name="genre" class="form-control" 
                   value="<?= htmlspecialchars($game['genre']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Rating</label>
            <input type="number" name="rating" step="0.1" min="1" max="10" 
                   class="form-control"
                   value="<?= htmlspecialchars($game['rating']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Released Date</label>
            <input type="date" name="released_date" class="form-control" 
                   value="<?= htmlspecialchars($game['released_date']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="game_desc" rows="4" class="form-control"><?= 
                htmlspecialchars($game['game_desc']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="index.php" class="btn btn-secondary">← Cancel</a>

    </form>

</div>
</body>
</html>
