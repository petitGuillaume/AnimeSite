<?php

function filterAnime($studioId, $creatorId, $univerID, $genres, $searchTerm, $yearMin, $yearMax)
{
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';
  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT Anime.*,
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
WHERE 1=1";
    if (!empty($studioId)) {
      $query .= " AND ID_studio = :studioId";
    }
    if (!empty($yearMin)) {
      $query .= " AND Year >= :yearMin";
    }
  
    if (!empty($yearMax)) {
      $query .= " AND Year <= :yearMax";
    }
    if (!empty($creatorId)) {
      $query .= " AND Id_createur = :creatorId";
    }

    if (!empty($univerID)) {
      $query .= " AND ID_univers = :univerID";
    }

    if (!empty($genres)) {
      $genreIds = implode(',', $genres);
      $numGenres = count($genres);

  $query .= " AND ID_Anime IN (
    SELECT ID_Anime
    FROM Anime_Genres
    WHERE ID_Genre IN ($genreIds)
    GROUP BY ID_Anime
    HAVING COUNT(DISTINCT ID_Genre) = $numGenres
  )";  }

    if (!empty($searchTerm)) {
      $query .= " AND (Name_Jp LIKE :searchTerm OR Name_Fr LIKE :searchTerm)  GROUP BY Anime.ID, Studios.Name, univers.Name, Createurs.Name";
    }
    else{
      $query .= " GROUP BY Anime.ID, Studios.Name, univers.Name, Createurs.Name ORDER BY  Anime.Name_Fr ASC";
    }

    $stmt = $pdo->prepare($query);

    if (!empty($studioId)) {
      $stmt->bindParam(':studioId', $studioId, PDO::PARAM_INT);
    }

    if (!empty($creatorId)) {
      $stmt->bindParam(':creatorId', $creatorId, PDO::PARAM_INT);
    }
    if (!empty($univerID)) {
      $stmt->bindParam(':univerID', $univerID, PDO::PARAM_INT);
    }

    if (!empty($yearMin)) {
      $stmt->bindParam(':yearMin', $yearMin, PDO::PARAM_INT);
    }
  
    if (!empty($yearMax)) {
      $stmt->bindParam(':yearMax', $yearMax, PDO::PARAM_INT);
    }
    if (!empty($searchTerm)) {
      $searchTerm = "%$searchTerm%";
      $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return false;
  }
}

function getAllAnime()
{
 
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';

  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all anime data
    $query = "SELECT * FROM Anime";
    $stmt = $pdo->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return false;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
  include_once('anime.lib.php');

  $action = $_POST["action"];

  if ($action == "filter") {
    $studioId = isset($_POST["studioId"]) ? $_POST["studioId"] : null;
    $creatorId = isset($_POST["creatorId"]) ? $_POST["creatorId"] : null;
    $univerID = isset($_POST["univerID"]) ? $_POST["univerID"] : null;
    $yearMin = isset($_POST["yearMin"]) ? $_POST["yearMin"] : null;
    $yearMax = isset($_POST["yearMax"]) ? $_POST["yearMax"] : null;

    $genres = isset($_POST["genres"]) ? $_POST["genres"] : array();
    $searchTerm = isset($_POST["searchTerm"]) ? $_POST["searchTerm"] : null;

    $filteredAnime = filterAnime($studioId, $creatorId, $univerID ,$genres, $searchTerm, $yearMin, $yearMax);

    echo json_encode($filteredAnime);
    exit;
  } elseif ($action == "fetchAll") {
    $allAnime = getAllAnime();

    echo json_encode($allAnime);
    exit;
  }
}

function fetchStudios()
{
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';

  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT s.*
    FROM Studios s
    WHERE EXISTS (
        SELECT *
        FROM anime a
        WHERE a.ID_studio = s.ID
        GROUP BY a.ID_studio
    )
    ORDER BY Name ASC;";
    $stmt = $pdo->query($query);
    $studios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $studios;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return array(); 
  }
}



function fetchCreator()
{
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';

  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT c.ID, c.Name FROM createurs c
        WHERE EXISTS (
        SELECT *
        FROM anime a
        WHERE a.ID_studio = C.ID
        GROUP BY a.ID_studio
    ) order by Name asc";
    $stmt = $pdo->query($query);
    $creators = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $creators;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return array(); 
  }
}


function fetchGenres()
{
  // Replace with your actual database connection code
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';

  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch genre data
    $query = "SELECT ID, name FROM Genres";
    $stmt = $pdo->query($query);
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $genres;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return array(); // Return an empty array in case of an error
  }
}

function fetchUniver()
{
  // Replace with your actual database connection code
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';

  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch genre data
    $query = "SELECT u.*
    FROM univers u
    WHERE EXISTS (
        SELECT 1
        FROM anime a
        WHERE a.ID_univers = u.ID
        GROUP BY a.ID_univers
        HAVING COUNT(*) >= 2) order by u.name asc";
    $stmt = $pdo->query($query);
    $univers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $univers;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return array(); // Return an empty array in case of an error
  }
}

?>