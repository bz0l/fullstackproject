<?php
// Connect to database
include("db.php");

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid game ID.");
}

$id = (int) $_GET['id'];

// Use prepared statement
$stmt = $mysqli->prepare("SELECT game_name, game_desc, genre, rating, released_date, game_image FROM videogames WHERE game_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Game not found.");
}

$game = $result->fetch_assoc();

// Helper to display stars for rating out of 5
function renderStars($rating) {
    $stars = '';
    $rating = floatval($rating);
    for ($i = 1; $i <= 10; $i++) {
        if ($i <= $rating) {
            $stars .= '<span class="text-warning">&#9733;</span>'; // filled star
        } else {
            $stars .= '<span class="text-muted">&#9733;</span>'; // empty star
        }
    }
    return $stars;
}

// Format release date nicely
$releaseDate = !empty($game['released_date']) ? date("F j, Y", strtotime($game['released_date'])) : "Unknown";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($game['game_name']) ?> - Game Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
	
		/* Custom Styling for Dark Theme */
      body {
        background-color: #121212; /* Dark background for the body */
        color: #f8f9fa; /* Light text for better contrast */
      }

	  .container {
        background-color: #1e1e1e; /* Dark container background */
        border-radius: 8px;
        padding: 20px;
      }
      .game-image {
            max-width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>
<div class="container my-5">

    <!-- Back Button -->
    <a href="index.php" class="btn btn-secondary mb-4">&laquo; Back to list</a>

    <!-- Game Card -->
    <div class="card shadow-lg p-4">
        <?php if (!empty($game['game_image'])): ?>
            <img src="<?= htmlspecialchars($game['game_image']) ?>" alt="<?= htmlspecialchars($game['game_name']) ?>" class="game-image rounded">
        <?php endif; ?>

        <h1 class="card-title text-center mb-3"><?= htmlspecialchars($game['game_name']) ?></h1>

        <!-- Genre Badge -->
        <?php if (!empty($game['genre'])): ?>
            <p class="text-center">
                <span class="badge bg-primary"><?= htmlspecialchars($game['genre']) ?></span>
            </p>
        <?php endif; ?>

        <!-- Rating Stars -->
        <?php if (!empty($game['rating'])): ?>
            <p class="text-center mb-3"><?= renderStars($game['rating']) ?></p>
        <?php endif; ?>

        <!-- Release Date -->
        <p class="text-center text-muted mb-4"><strong>Released:</strong> <?= $releaseDate ?></p>

        <!-- Description -->
        <p class="card-text"><?= nl2br(htmlspecialchars($game['game_desc'])) ?></p>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
