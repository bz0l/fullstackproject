<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajax demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-4">
      <h1 class="mb-4">🎮 Game Search</h1>

      <form class="row g-3 mb-3">
        <div class="col-auto">
          <input type="text" class="form-control" id="searchBox" placeholder="Enter keywords...">
        </div>
      </form>	

      <div id="results"></div>
    </div>

    <script>
    // Listen for key presses in the search box
    document.getElementById("searchBox").addEventListener("keyup", doSearch);

    function doSearch() {
      const keywords = document.getElementById("searchBox").value.trim();

      // If empty, clear results and exit
      if (keywords === "") {
        document.getElementById("results").innerHTML = "";
        return;
      }

      // Call server-side script
      fetch('https://mi-linux.wlv.ac.uk/~2432878/year2/ajax.php?search=' + encodeURIComponent(keywords))
        .then(response => response.json())
        .then(response => {
          const resultsDiv = document.getElementById("results");
          resultsDiv.innerHTML = ""; // clear previous results

          if (response.length === 0) {
            resultsDiv.innerHTML = `<div class="alert alert-warning">No games found.</div>`;
            return;
          }

          // Build Bootstrap table
          let tableHTML = `
            <table class="table table-striped table-bordered align-middle">
              <thead class="table-dark">
                <tr>
                  <th scope="col">Game Name</th>
                  <th scope="col">Genre</th>
                  <th scope="col">Rating</th>
                  <th scope="col">Released Date</th>
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
              </tr>
            `;
          });

          tableHTML += `</tbody></table>`;
          resultsDiv.innerHTML = tableHTML;
        })
        .catch(err => {
          document.getElementById("results").innerHTML = `
            <div class="alert alert-danger">Error fetching results.</div>
          `;
          console.error(err);
        });
    }
    </script>
  </body>
</html>
