<!doctype html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add a Videogame</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
 </head>
 <body>
    <div class="container mt-4">
        <h1>Add a Videogame</h1>
        <form action="add-game.php" method="post">
			<div class="mb-3">
               <label for="GameImage" class="form-label">Poster (paste image url)</label>
               <input type="text" class="form-control" id="game_image" name="GameImage" required>
            </div>
            <div class="mb-3">
                <label for="GameName" class="form-label">Game Name</label>
                <input type="text" class="form-control" id="game_name" name="GameName" required>
            </div>
            <div class="mb-3">
                <label for="GameDescription" class="form-label">Description</label>
                <textarea class="form-control" id="game_desc" name="GameDescription" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="DateReleased" class="form-label">Date Released</label>
                <input type="date" class="form-control" id="released_date" name="DateReleased">
            </div>
            <div class="mb-3">
                <label for="GameRating" class="form-label">Rating</label>
                <input type="number" class="form-control" id="rating" name="GameRating" min="0" max="10" step="0.1">
            </div>
            <div class="mb-3">
                <label for="GameGenre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="GameGenre">
            </div>
            <input type="submit" class="btn btn-primary" value="Add Game">
        </form>
    </div>
 </body>
</html>
