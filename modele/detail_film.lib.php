
<?php
$dbHost = 'localhost';
$dbName = 'db_anime';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer l'ID du film depuis GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $filmId = $_GET['id'];

    // Interroger la base de données pour obtenir les détails du film
    $query = "SELECT * FROM film WHERE ID = :filmId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Récupérer les données du film
    $film = $stmt->fetch(PDO::FETCH_ASSOC);

    // Interroger la base de données pour obtenir des films du même univers
    $relatedQuery = "SELECT ID, image, Name_Jp
    FROM film
    WHERE ID_univers = (SELECT ID_univers FROM film WHERE ID = :filmId)
    AND ID <> :filmId";
    $relatedStmt = $pdo->prepare($relatedQuery);
    $relatedStmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
    $relatedStmt->execute();

    // Récupérer les données des film du même univers
    $relatedFilmList = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Rediriger en cas d'ID non valide
    header("Location: film_details.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Récupérer l'ID du film depuis l'URL
    $filmId = $_GET['id'];

    // Préparation de la requête pour récupérer les animes liés au film
    $relatedSourceQuery = "SELECT anime.ID, anime.Image, anime.Name_Fr
                           FROM anime
                           INNER JOIN film ON film.ID_Source = anime.ID
                           WHERE film.ID = :filmId";
    
    // Préparation de la requête avec PDO
    $relatedSourceStmt = $pdo->prepare($relatedSourceQuery);
    
    // Liaison du paramètre filmId
    $relatedSourceStmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
    
    // Exécuter la requête
    $relatedSourceStmt->execute();
    
    // Récupérer les résultats
    $results = $relatedSourceStmt->fetchAll(PDO::FETCH_ASSOC);
}else{}