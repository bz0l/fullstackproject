<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List of All My Games</title>
  <base href="https://mi-linux.wlv.ac.uk/~2432878/year2/">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h1 class="text-center mb-4">List of All My Games</h1>

    <?php
      include("db.php");
      $sql = "SELECT * FROM videogames ORDER BY released_date";
      $results = mysqli_query($mysqli, $sql);
    ?>

    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Game Name</th>
          <th>Rating</th>
        </tr>
      </thead>
      <tbody>
        <?php while($a_row = mysqli_fetch_assoc($results)): ?>
          <tr>
            <td>
              <a href="game-details.php?id=<?=$a_row['game_id']?>" class="text-primary">
                <?=$a_row['game_name']?>
              </a>
            </td>
            <td><?=$a_row['rating']?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <div class="text-center mt-3">
      <a href="add-game-form.php" class="btn btn-primary">Add a Game</a>
    </div>
  </div>
</body>
</html>
