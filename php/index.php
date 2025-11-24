<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajax Game Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-4">
      <h1 class="mb-4">Game Search</h1>

      <div class="d-flex justify-content-between mb-3">
        <form class="flex-grow-1 me-2">
          <input type="text" class="form-control" id="searchBox" placeholder="Enter keywords...">
        </form>
        <a href="add-game-form.php" class="btn btn-success">Add Game</a>
      </div>

      <div id="results"></div>
    </div>

    <script>
    // Listen for key presses in the search box
    document.getElementById("searchBox").addEventListener("keyup", () => doSearch(false));

    // Load all games on page load
    window.onload = () => doSearch(true);

    function doSearch(initialLoad = false) {
      let keywords = document.getElementById("searchBox").value.trim();

      if (initialLoad) keywords = "";

      fetch('https://mi-linux.wlv.ac.uk/~2432878/year2/ajax.php?search=' + encodeURIComponent(keywords))
        .then(response => response.json())
        .then(response => {
          const resultsDiv = document.getElementById("results");
          resultsDiv.innerHTML = "";

          if (!response.length) {
            resultsDiv.innerHTML = `<div class="alert alert-warning">No games found.</div>`;
            return;
          }

          let tableHTML = `
            <table class="table table-striped table-bordered align-middle">
              <thead class="table-dark">
                <tr>
                  <th>Game Name</th>
                  <th>Genre</th>
                  <th>Rating</th>
                  <th>Released</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
          `;

          response.forEach(game => {
            tableHTML += `
              <tr>
                <td>${game.game_name}</td>
                <td>${game.genre || 'N/A'}</td>
                <td>${game.rating || 'N/A'}</td>
                <td>${game.released_date || 'Unknown'}</td>
                <td>${game.game_desc || 'Unknown'}</td>
                <td>
                  <a class="btn btn-sm btn-primary" href="game-details.php?id=${game.game_id}">View</a>
                  <a class="btn btn-sm btn-warning" href="update-game.php?id=${game.game_id}">Edit</a>
                  <button class="btn btn-sm btn-danger" onclick="deleteGame(${game.game_id})">Delete</button>
                </td>
              </tr>
            `;
          });

          tableHTML += `</tbody></table>`;
          resultsDiv.innerHTML = tableHTML;
        })
        .catch(err => {
          document.getElementById("results").innerHTML = `<div class="alert alert-danger">Error fetching results.</div>`;
          console.error(err);
        });
    }

    function deleteGame(id) {
      if (!confirm("Are you sure you want to delete this game?")) return;

      fetch('delete-game.php?id=' + id)
        .then(() => doSearch(true))
        .catch(err => alert("Error deleting game"));
    }
    </script>
  </body>
</html>
