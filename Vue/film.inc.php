<!-- Vue/anime.inc.php -->

<!DOCTYPE html>
<html>

<head>
  <title>Anime List</title>
</head>

<body>
  <!-- Include necessary JavaScript libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script> 
    // Function to update the table content based on filtered data
    function updateAnimeTable(data) {
      console.log("updateAnimeTable");
      var tableContent = '';
      data.forEach(function (anime) {
        tableContent += '<tr>';
        tableContent += '<td>' + anime.ID + '</td>';
        tableContent += '<td>' + anime.Name + '</td>';
        tableContent += '<td>' + anime.Name_Fr + '</td>';
        tableContent += '<td>' + anime.image + '</td>';
        tableContent += '<td>' + anime.Synopsis + '</td>';
        tableContent += '<td>' + anime.Year + '</td>';
        tableContent += '<td>' + anime.Nb_episodes + '</td>';
        tableContent += '<td>' + anime.Nb_OAV + '</td>';
        tableContent += '<td>' + anime.Nb_Film + '</td>';
        tableContent += '<td>' + anime.StudioName + '</td>'; // Display studio name
        tableContent += '<td>' + anime.CreatorName + '</td>'; // Display creator name
        tableContent += '<td>' + anime.UniverseName + '</td>'; // Display universe name
        tableContent += '<td>' + anime.GenresList + '</td>'; // Display concatenated genre names
        tableContent += '</tr>';
   
      });
      console.log("end");
      $("#anime_table").html(tableContent);
    }

    // Function to filter and update the table
    function filterAnime() {
      console.log("filterAnime");
      var studioId = $("#studio_filter").val();
      var creatorId = $("#creator_filter").val();
      var univerID = $("#univer_filter").val();
      var yearMin = $("#yearMin").val();
      var yearMax = $("#yearMax").val();
      var genres = $("input[name='genre_filter[]']:checked").map(function () {
        return this.value;
      }).get();
      var searchTerm = $("#search_input").val().trim().toLowerCase();

      // Fetch all anime data
      console.log("ajax");

      $.ajax(
        {
          type: "POST",
          url: "modele/film.lib.php", // PHP file that contains functions to fetch anime data
          data: {
            action: "filter",
            studioId: studioId,
            creatorId: creatorId,
            univerID: univerID,
            genres: genres,
            searchTerm: searchTerm,
            yearMin: yearMin,
           yearMax: yearMax,
          },
          dataType: "json",
          success: function (response) {
            console.log("Requête AJAX réussie. Réponse du serveur :");
    console.log(response); // Affiche la réponse du serveur dans la console
    console.log("Mise à jour du tableau avec les données filtrées...");
    updateAnimeTable(response);
          },
        });
    }

    // Function to handle form element changes and trigger filtering
    function handleFilterChanges() {
      // Trigger filtering when studio filter changes
      $("#studio_filter").change(filterAnime);

      // Trigger filtering when creator filter changes
      $("#creator_filter").change(filterAnime);

      // Trigger filtering when univer filter changes
      $("#univer_filter").change(filterAnime);

      // Trigger filtering when genre filter changes
      $("input[name='genre_filter[]']").change(filterAnime);
      console.log("test");

      // Trigger filtering when search input changes
      $("#search_input").keyup(filterAnime);
      $("#yearMin").on("change", filterAnime);

// Trigger filtering when yearMax input changes
$("#yearMax").on("change", filterAnime);
    }

    // Initial page load, fetch all anime data and display the table
    $(document).ready(function () {
      // Fetch all anime data and display the table
      filterAnime();
      // Handle form element changes and trigger filtering
      handleFilterChanges();
    });
    function resetFilters() {
  // Reset select elements
  $("#studio_filter, #creator_filter, #univer_filter").val("");

  // Reset genre checkboxes
  $("input[name='genre_filter[]']").prop("checked", false);

  // Clear search input
  $("#search_input").val("");

  // Trigger filtering with reset values
  filterAnime();
}

    $(document).on("click", "#reset_filters", resetFilters);

  </script>

  <h1>Anime List</h1>

  <!-- Filter Form -->
  <form>
    <label for="studio_filter">Filter by Studio:</label>
    <select id="studio_filter">
      <option value="">All</option>
      <?php
      // Fetch studio data from the database (Replace with your database query)
      $studios = fetchStudios();

      // Loop through studios to create dropdown options
      foreach ($studios as $studio) {
        echo '<option value="' . $studio['ID'] . '">' . $studio['Name'] . '</option>';
      }
      ?>
    </select>

    <br>

    <label for="creator_filter">Filter by creator:</label>
    <select id="creator_filter">
      <option value="">All</option>
      <?php
      // Fetch studio data from the database (Replace with your database query)
      $creators = fetchCreator();
      // Loop through studios to create dropdown options
      foreach ($creators as $creator) {
        echo '<option value="' . $creator['ID'] . '">' . $creator['Name'] . '</option>';
      }
      ?>

    </select> <br>
    <label for="univer_filter">Filter by univer:</label>
    <select id="univer_filter">
      <option value="">All</option>
      <?php
      // Fetch studio data from the database (Replace with your database query)
      $univers = fetchUniver();

      // Loop through studios to create dropdown options
      foreach ($univers as $univer) {
        echo '<option value="' . $univer['ID'] . '">' . $univer['name'] . '</option>';
      }
      ?>
    </select>
    <br>
    <br>
    <label>Filter by Genre:</label><br>
    <?php
    // Fetch genre data from the database using the fetchGenres function
    $genres = fetchGenres();

    // Loop through genres to create checkbox options
    foreach ($genres as $genre) {
      echo '<input type="checkbox" name="genre_filter[]" value="' . $genre['ID'] . '"> ' . $genre['name'] . '<br>';
    }
    ?>
    </select>
    <!-- Add more checkboxes based on your database -->
    <br>
  </form>

  <!-- Search Form -->
  <label for="search_input">Search by Anime Name:</label>
  <input type="text" id="search_input">

  <label for="yearMin">Filter by Year (Min):</label>
<input type="number" id="yearMin" min="1900" max="2099" value="1950">

<label for="yearMax">Filter by Year (Max):</label>
<input type="number" id="yearMax" min="1900" max="2099" value="2023">



  <button type="button" id="reset_filters">Réinitialiser les Filtres</button>
  <!-- Table to display anime data -->
  <table border="1">
    <tr>
      <th>ID</th>
      <th>Name (Japanese)</th>
      <th>Name (French)</th>
      <th>Image</th>
      <th>Synopsis</th>
      <th>Year</th>
      <th>Number of Episodes</th>
      <th>Number of OAV</th>
      <th>Number of Films</th>
      <th>Studio</th>
      <th>Creator</th>
      <th>Universe</th>
      <th>Genres</th>
    </tr>
    <tbody id="anime_table">
      <!-- The content will be populated through AJAX calls -->
    </tbody>
  </table>
</body>

</html>

