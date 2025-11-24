<!DOCTYPE html>
<html>
<head>
    <title>Game search</title>

    <!-- BOOTSTRAP CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet">
</head>
<body class="p-4">

<?php
include("db.php");

// Check if form submitted
$keywords = $_POST['keywords'] ?? '';

$results = null;

if ($keywords !== '') {
    // Escape input
    $safe_keywords = $mysqli->real_escape_string($keywords);

    // Query database
    $sql = "SELECT * FROM videogames
            WHERE game_name LIKE '%{$safe_keywords}%'
            ORDER BY released_date";

    $results = mysqli_query($mysqli, $sql);
}
?>

<h1 class="mb-4">Search Games</h1>

<!-- BOOTSTRAP SEARCH BOX -->
<form method="POST" class="mb-4">
    <div class="input-group">
        <input type="text" 
               name="keywords" 
               class="form-control" 
               placeholder="Search for a game..."
               value="<?=htmlspecialchars($keywords)?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>


<h2>Search results</h2>

<?php if ($keywords === ''): ?>

    <div class="alert alert-info">No search terms entered.</div>

<?php elseif (mysqli_num_rows($results) === 0): ?>

    <div class="alert alert-warning">
        No results found for <strong><?=htmlspecialchars($keywords)?></strong>
    </div>

<?php else: ?>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>Game</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        <?php while($a_row = mysqli_fetch_assoc($results)): ?>
        <tr>
            <td>
                <a href="game-details.php?id=<?=$a_row['game_id']?>">
                    <?=htmlspecialchars($a_row['game_name'])?>
                </a>
            </td>
            <td><?=htmlspecialchars($a_row['rating'])?></td>
			<td><?=htmlspecialchars($a_row['genre'])?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php endif; ?>

</body>
</html>
