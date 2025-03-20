
<?php
include_once("modele/pdo.lib.php");


// Récupérer l'ID de l'anime depuis GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $animeId = $_GET['id'];

    // Interroger la base de données pour obtenir les détails de l'anime
    $query = "SELECT * FROM Anime WHERE ID = :animeId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':animeId', $animeId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Récupérer les données de l'anime
    $anime = $stmt->fetch(PDO::FETCH_ASSOC);

    // Interroger la base de données pour obtenir les animes du même univers
    $relatedQuery = "SELECT ID, image, Name_Jp
    FROM Anime
    WHERE ID_univers = (SELECT ID_univers FROM Anime WHERE ID = :animeId)
    AND ID <> :animeId";
    $relatedStmt = $pdo->prepare($relatedQuery);
    $relatedStmt->bindParam(':animeId', $animeId, PDO::PARAM_INT);
    $relatedStmt->execute();

    // Récupérer les données des animes du même univers
    $relatedAnimeList = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Rediriger en cas d'ID non valide
    header("Location: anime_details.php");
    exit();
}


// Interroger la base de données pour obtenir les anime ayant ID_Source égal à l'ID donné
$relatedSourceQuery = "SELECT image, Name_Fr, Anime_Type
                       FROM Anime
                       WHERE ID_Source = :animeId";
$relatedSourceStmt = $pdo->prepare($relatedSourceQuery);
$relatedSourceStmt->bindParam(':animeId', $animeId, PDO::PARAM_INT);
$relatedSourceStmt->execute();

// Récupérer les données des anime ayant ID_Source égal à l'ID donné
$relatedSourceAnimeList = $relatedSourceStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// Interroger la base de données pour obtenir les anime ayant ID_Source égal à l'ID donné
$anime_antéQuery = "SELECT image, Name_Fr
FROM Anime
WHERE ID = (SELECT ID_Source FROM Anime WHERE ID = :animeId)";
$anime_antéStmt = $pdo->prepare($anime_antéQuery);
$anime_antéStmt->bindParam(':animeId', $animeId, PDO::PARAM_INT);
$anime_antéStmt->execute();

// Récupérer les données des anime ayant ID_Source égal à l'ID donné
$anime_antéList = $anime_antéStmt->fetchAll(PDO::FETCH_ASSOC);

