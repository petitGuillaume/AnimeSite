<!-- Vue/anime.inc.php -->

<!DOCTYPE html>
<html>

<head>
  <title>Liste des Anime</title>
  <link href="ressource/css/styles.css" rel="stylesheet">

</head>

<body>
  <!-- Include necessary JavaScript libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="ressource/js/Anime-Script.js" defer></script>


  <div class="blockForm">
    <form>
      <div class="formFirstLign">
        <div>
          <label for="search_input">Nom :</label>
          <input type="text" id="search_input">
        </div>
        <div class="slider-container">
          <h2>Période de sortie</h2>
            <div class="values">
              <span id="range1">1950</span> - <span  id="range2">2024</span>
            </div>
            <div class="slider-track"></div>
            <input  id="yearMin"  value="1950" type="range" min="1950" max="2024" >
            <input  id="yearMax" value="2024" type="range" min="1950" max="2024">
         </div>
      </div>

      <div class="formSecondLign">
        <div>
          <label  class="tittle_Filer" for="studio_filter">Studio :</label>
          <select id="studio_filter">
            <option value="">Studio</option>
            <?php
              $studios = fetchStudios();
                foreach ($studios as $studio) {
                  echo '<option value="' . $studio['ID'] . '">' . $studio['Name'] . '</option>';
                }
            ?>
          </select>
        </div>
        <div>
          <label  class="tittle_Filer" for="creator_filter">Créateur :</label>
          <select id="creator_filter">
            <option value="">Créateur</option>
            <?php
              $creators = fetchCreator();
                foreach ($creators as $creator) {
                  echo '<option value="' . $creator['ID'] . '">' . $creator['Name'] . '</option>';
                }
             ?>
        
          </select> 
          <br>
        </div>
        <div>
          <label class="tittle_Filer" for="univer_filter">Univers :</label>
          <select id="univer_filter">
            <option value="">Univers</option>
            <?php
              $univers = fetchUniver();
                foreach ($univers as $univer) {
                  echo '<option value="' . $univer['ID'] . '">' . $univer['Name'] . '</option>';
                }
            ?>
          </select>
        </div>
      </div>
      <div class="formTheirdLign">
          <?php
          $genres = fetchGenres();
            foreach ($genres as $genre) {
               echo '<div class="checkboxGenres"><input class="Custom-checkbox" type="checkbox" name="genre_filter[]" value="' . $genre['ID'] . '"> ' . $genre['name'] . '</div>';
            }
          ?>
        <br> 
      </div>
      <button type="button" id="reset_filters">Réinitialiser les Filtres</button>
    </form>
  </div>

  <div id="film_table">
  </div>

  <a id="backToTop">↑</a>


</body>

</html>