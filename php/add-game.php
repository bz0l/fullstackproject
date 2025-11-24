<?php
include("db.php"); // database connection

// Only run if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read and sanitize values from form
    $game_name = isset($_POST['GameName']) ? $mysqli->real_escape_string($_POST['GameName']) : '';
    $game_description = isset($_POST['GameDescription']) ? $mysqli->real_escape_string($_POST['GameDescription']) : '';
    $released_date = isset($_POST['DateReleased']) ? $_POST['DateReleased'] : null; // YYYY-MM-DD
    $game_rating = isset($_POST['GameRating']) ? $mysqli->real_escape_string($_POST['GameRating']) : '';
    $genre = isset($_POST['GameGenre']) ? $mysqli->real_escape_string($_POST['GameGenre']) : '';

    // Set NULL if date is empty
    $released_date_sql = ($released_date && $released_date !== '') ? "'$released_date'" : "NULL";

    // Build SQL statement including genre
    $sql = "INSERT INTO videogames (game_name, game_desc, released_date, rating, genre)
            VALUES ('$game_name', '$game_description', $released_date_sql, '$game_rating', '$genre')";

    // Run SQL statement
    if (!$mysqli->query($sql)) {
        echo "<h4>SQL error: " . $mysqli->error . "</h4>";
    } else {
        // Redirect to index page after successful insert
        header("Location: index.php");
        exit();
    }
}
?>
