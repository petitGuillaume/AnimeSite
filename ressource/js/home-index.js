$(document).ready(function () {
    $.ajax({
        url: 'modele/home.lib.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            var content = '';
            data.forEach(function (anime) {

                content += '<a href="index.php?detail_anime&id=' + anime.ID + '">';
                content += '<div class="anime-item"><img class="ani" src="ressource/img/anime_img/' + anime.Image + '" />';
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
            $('#anime-list').html(content);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});