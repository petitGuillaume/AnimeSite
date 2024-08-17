
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


// Interroger la base de données pour obtenir les anime ayant ID_Source égal à l'ID donné
$relatedSourceQuery = "SELECT image, Name_Fr
                       FROM film
                       WHERE ID_Source = :filmId";
$relatedSourceStmt = $pdo->prepare($relatedSourceQuery);
$relatedSourceStmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
$relatedSourceStmt->execute();

// Récupérer les données des anime ayant ID_Source égal à l'ID donné
$relatedSourceFilmList = $relatedSourceStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// Interroger la base de données pour obtenir les anime ayant ID_Source égal à l'ID donné
$film_antéQuery = "SELECT image, Name_Fr
FROM film
WHERE ID = (SELECT ID_Source FROM film WHERE ID = :filmId)";
$film_antéStmt = $pdo->prepare($film_antéQuery);
$film_antéStmt->bindParam(':filmId', $animeId, PDO::PARAM_INT);
$film_antéStmt->execute();

// Récupérer les données des anime ayant ID_Source égal à l'ID donné
$film_antéList = $film_antéStmt->fetchAll(PDO::FETCH_ASSOC);

