    // Function to update the table content based on filtered data
    function updateAnimeTable(data) {
        console.log("updateAnimeTable");
        var content = '';
        data.forEach(function (anime) {
  
          content += '<a href="index.php?detail&id=' + anime.ID + '">';
          content += '<div class="anime-item"><img class="ani" src="ressource/img/anime_img/' + anime.Image + '"/>';
          content += '<div class="bigblock">';
          content += '<div class="blocktittle">';
          content += '<div class="tittle">' + anime.Name_Fr + '</div>';
          content += '<div class="minitittle">' + anime.Name_Jp + '</div>';
          content += '</div>';
          content += '<div class="blockcolon">';
          content += '<div class="minicolon">';
          content += '<div class="paragraphe"><span class="gras">Studio : </span>' + anime.StudioName + '</div>';
          content += '<div class="paragraphe"><span class="gras">Createur : </span>' + anime.CreatorName + '</div>';
          content += '<div class="paragraphe"><span class="gras">Année : </span>' + anime.Year + '</div>';
          content += '</div>';
          content += '<div class="minicolon colgenre">';
  
  
          var genresArray = anime.GenresList.split(', ');
          genresArray.sort();
          genresArray.forEach(function (genre) {
            content += '<div class="genreblock ' + genre + '"><img class="miniImg" src="ressource/img/genres/' + genre + '.png"><p class="TextGenre">' + genre + '</p></div>';
          });
          content += '</div>';
          content += '<div class="minicolon coloneChiffre">';
          content += '<div class="paragraphe"><span class="gras">Episode : </span>' + anime.Nb_episodes + '</div>';
          content += '<div class="paragraphe"><span class="gras">OAV : </span>' + anime.Nb_OAV + '</div>';
          content += '<div class="paragraphe"><span class="gras">Film : </span>' + anime.Nb_Film + '</div>';
          content += '</div> </div></div></div></a>';
  
        });
        console.log("end");
        $("#anime_table").html(content);
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
            url: "modele/anime.lib.php", // PHP file that contains functions to fetch anime data
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
        filterAnime();
        handleFilterChanges();
      });
  
      
      function resetFilters() {
        const date = new Date();
        const anneeActuelle = date.getFullYear();
        $("#studio_filter, #creator_filter, #univer_filter").val("");
  
        $("input[name='genre_filter[]']").prop("checked", false);
  
        $("#search_input").val("");
  
        $("#yearMin").val("1950");
        $("#yearMax").val(anneeActuelle);
        filterAnime();
      }
  
      $(document).on("click", "#reset_filters", resetFilters);
  
/**************** */

      window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
          document.getElementById("backToTop").style.display = "block";
        } else {
          document.getElementById("backToTop").style.display = "none";
        }
      });
  
      document.getElementById("backToTop").addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
      });