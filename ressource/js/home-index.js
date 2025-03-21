$(document).ready(function () {
    $.ajax({
        url: 'modele/home.lib.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            var content = '';

            data.forEach(function (anime) {
                content += '<a href="index.php?detail_anime&id=' + encodeURIComponent(anime.ID) + '">';
                content += '<div class="anime-item">';
                content += '<img class="ani" src="ressource/img/anime_img/' + anime.Image + '" alt="' + anime.Name_Fr + '" />';
                content += '<div class="bigblock">';
                content += '<div class="blocktittle">';
                content += '<div class="tittle">' + anime.Name_Fr + '</div>';
                content += '<div class="minitittle">' + anime.Name_Jp + '</div>';
                content += '</div>';
                content += '<div class="blockcolon">';
                content += '<div class="minicolon">';
                content += '<div class="paragraphe"><span class="gras">Studio : </span>' + anime.StudioName + '</div>';
                content += '<div class="paragraphe"><span class="gras">Créateur : </span>' + anime.CreatorName + '</div>';
                content += '<div class="paragraphe"><span class="gras">Année : </span>' + anime.Year + '</div>';
                content += '</div>';
                content += '<div class="minicolon colgenre">';

                // Vérifier si GenresList existe et n'est pas vide
                if (anime.GenresList) {
                    var genresArray = anime.GenresList.split(', ').sort();
                    genresArray.forEach(function (genre) {
                        content += '<div class="genreblock ' + genre + '">';
                        content += '<img class="miniImg" src="ressource/img/genres/' + genre + '.png" alt="' + genre + '">';
                        content += '<p class="TextGenre">' + genre + '</p></div>';
                    });
                }

                content += '</div>';
                content += '<div class="minicolon coloneChiffre">';
                content += '<div class="paragraphe"><span class="gras">Épisode : </span>' + anime.Nb_episodes + '</div>';
                content += '<div class="paragraphe"><span class="gras">OAV : </span>' + anime.Nb_OAV + '</div>';
                content += '<div class="paragraphe"><span class="gras">Film : </span>' + anime.Nb_Film + '</div>';
                content += '</div></div></div></div></a>';
            });

            $('#anime-list').html(content);
        },
        error: function (xhr, status, error) {
            console.error("Erreur AJAX : ", error);
            console.log("Réponse serveur : ", xhr.responseText);
        }
    });
});