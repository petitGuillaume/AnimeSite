<?php
/**
 * Modele de la page de garde

 *
 */

function starAnime()
{
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';
  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "   SELECT Anime.*,
    Studios.Name AS StudioName,
    univers.Name AS UniverseName,
    Createurs.Name AS CreatorName,
    GROUP_CONCAT(Genres.name SEPARATOR ', ') AS GenresList
    FROM Anime
    LEFT JOIN Studios ON Anime.ID_studio = Studios.ID
    LEFT JOIN univers ON Anime.ID_univers = univers.ID
    LEFT JOIN Createurs ON Anime.Id_createur = Createurs.ID
    LEFT JOIN Anime_Genres ON Anime.ID = Anime_Genres.ID_Anime
    LEFT JOIN Genres ON Anime_Genres.ID_genre = Genres.ID
    WHERE 1=1
    GROUP BY Anime.ID, Studios.Name, univers.Name, Createurs.Name
    ORDER BY Anime.ID DESC
    LIMIT 3 ";


    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return false;
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $animeData = starAnime();
  echo json_encode($animeData); // Output the data in JSON format
}