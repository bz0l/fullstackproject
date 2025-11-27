<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Game Library</title>
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

      h1 {
        color: #ffffff; /* White heading for contrast */
        font-size: 2rem; /* Larger font size for better readability */
      }

      .game-card {
        transition: transform 0.2s ease-in-out;
        background-color: #2c2c2c; /* Dark card background */
        border: none;
        border-radius: 10px;
        color: #e0e0e0; /* Ensuring the text inside cards is accessible */
      }

      .game-card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
      }

      .game-img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 10px;
      }

      .game-title {
        font-size: 1.5rem; /* Larger title for visibility */
        font-weight: bold;
        color: #ffffff; /* White text for headings */
      }

      .game-desc {
        font-size: 1rem; /* Increased font size for readability */
        color: #b0b0b0; /* Slightly muted color for description */
      }

      .game-rating {
        font-size: 1.1rem; /* Larger text for rating */
        color: #f39c12; /* Gold color for rating */
      }

      /* Make Released Date More Readable */
      .game-released {
        font-size: 1rem;
        font-weight: bold;
        color: #ffc107; /* Use a bright color for contrast */
        background-color: #333333; /* Dark background for the text */
        padding: 2px 8px; /* Add some padding for readability */
        border-radius: 5px; /* Rounded corners */
      }

      .game-card-body {
        padding: 15px;
      }

      .btn {
        border-radius: 5px;
      }

      /* Darker Modal */
      .modal-content {
        background-color: #2c2c2c;
        color: #e0e0e0; /* Ensuring modal text is accessible */
      }

      .modal-header, .modal-footer {
        border-bottom: 1px solid #444;
      }

      /* Small Devices (Mobile) */
      @media (max-width: 576px) {
        .game-card {
          margin-bottom: 1rem;
        }
      }

      /* Links and Buttons Contrast */
      .btn, .card-title a {
        color: #f8f9fa !important; /* Ensure links and buttons are readable */
        font-weight: bold;
        text-decoration: none; /* Make sure links are styled properly */
      }

      .btn:hover, .card-title a:hover {
        color: #ffc107; /* Provide feedback on hover */
      }

      /* Add focus outline for accessibility */
      .btn:focus, .card-title a:focus {
        outline: 3px solid #ffbf47; /* Bright outline for focus visibility */
      }

    </style>
  </head>
  <body>
    <div class="container mt-4">
      <h1 class="mb-4 text-center">Game Library</h1>

      <!-- Search and Add Game Section -->
      <div class="d-flex justify-content-between mb-3">
        <form class="flex-grow-1 me-2">
          <input type="text" class="form-control" id="searchBox" placeholder="Search for games..." aria-label="Search for games">
        </form>
        <a href="add-game-form.php" class="btn btn-success" role="button" aria-label="Add a new game">Add Game</a>
      </div>

      <!-- Results Section -->
      <div id="results" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4"></div>
    </div>

    <!-- Modal for Deleting Game -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this game?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="confirmDeleteBtn" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Listen for key presses in the search box
      document.getElementById("searchBox").addEventListener("keyup", () => doSearch(false));

      // Load all games on page load
      window.onload = () => doSearch(true);

      let gameIdToDelete = null;

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

            let gameCardsHTML = '';

            response.forEach(game => {
              gameCardsHTML += `
                <div class="col">
                  <div class="card game-card shadow-sm">
                    <img src="${game.game_image || 'https://via.placeholder.com/300x400'}" class="card-img-top game-img" alt="${game.game_name}">
                    <div class="card-body game-card-body">
                      <h5 class="card-title game-title">${game.game_name}</h5>
                      <p class="card-text game-desc">${game.game_desc ? game.game_desc.substring(0, 100) + '...' : 'No description available.'}</p>
                      <p class="game-rating">Rating: ${game.rating || 'N/A'}</p>
                      <p class="game-released">Released: ${game.released_date || 'Unknown'}</p>
                      <div class="d-flex justify-content-between">
                        <a class="btn btn-sm btn-primary" href="game-details.php?id=${game.game_id}">View</a>
                        <a class="btn btn-sm btn-warning" href="update-game.php?id=${game.game_id}">Edit</a>
                        <button class="btn btn-sm btn-danger" onclick="prepareDelete(${game.game_id})">Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
              `;
            });

            resultsDiv.innerHTML = gameCardsHTML;
          })
          .catch(err => {
            document.getElementById("results").innerHTML = `<div class="alert alert-danger">Error fetching results.</div>`;
            console.error(err);
          });
      }

      // Prepare for deletion by setting the game ID
      function prepareDelete(id) {
        gameIdToDelete = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
      }

      // Confirm and delete the game
      function confirmDelete() {
        if (!gameIdToDelete) return;

        fetch('delete-game.php?id=' + gameIdToDelete)
          .then(() => {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.hide();
            doSearch(true);  // Reload the game list
          })
          .catch(err => {
            alert("Error deleting game");
            console.error(err);
          });
      }
    </script>

    <!-- Bootstrap JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
  </body>
</html>

