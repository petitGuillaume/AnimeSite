<?php

function filterAnime($studioId, $creatorId, $univerID, $genres, $searchTerm, $yearMin, $yearMax, $pdo)
{

    try {
      
        $query = "SELECT 
            Anime.*, 
            Studios.Name AS StudioName, 
            univers.Name AS UniverseName, 
            Createurs.Name AS CreatorName, 
            GROUP_CONCAT(DISTINCT Genres.name ORDER BY Genres.name SEPARATOR ', ') AS GenresList
        FROM Anime
        LEFT JOIN Studios ON Anime.ID_studio = Studios.ID
        LEFT JOIN univers ON Anime.ID_univers = univers.ID
        LEFT JOIN Createurs ON Anime.Id_createur = Createurs.ID
        LEFT JOIN Anime_Genres ON Anime.ID = Anime_Genres.ID_Anime
        LEFT JOIN Genres ON Anime_Genres.ID_genre = Genres.ID
        WHERE 1=1";

        $params = [];

        if (!empty($studioId)) {
            $query .= " AND Anime.ID_studio = :studioId";
            $params[':studioId'] = $studioId;
        }

        if (!empty($yearMin)) {
            $query .= " AND Anime.Year >= :yearMin";
            $params[':yearMin'] = $yearMin;
        }

        if (!empty($yearMax)) {
            $query .= " AND Anime.Year <= :yearMax";
            $params[':yearMax'] = $yearMax;
        }

        if (!empty($creatorId)) {
            $query .= " AND Anime.Id_createur = :creatorId";
            $params[':creatorId'] = $creatorId;
        }

        if (!empty($univerID)) {
            $query .= " AND Anime.ID_univers = :univerID";
            $params[':univerID'] = $univerID;
        }

        if (!empty($genres)) {
            $genrePlaceholders = [];
            foreach ($genres as $index => $genreId) {
                $paramName = ":genre$index";
                $genrePlaceholders[] = $paramName;
                $params[$paramName] = $genreId;
            }

            $query .= " AND Anime.ID IN (
                SELECT ID_Anime FROM Anime_Genres 
                WHERE ID_Genre IN (" . implode(',', $genrePlaceholders) . ") 
                GROUP BY ID_Anime 
                HAVING COUNT(DISTINCT ID_Genre) = :numGenres
            )";

            $params[':numGenres'] = count($genres);
        }

        if (!empty($searchTerm)) {
            $query .= " AND (Anime.Name_Jp LIKE :searchTerm OR Anime.Name_Fr LIKE :searchTerm)";
            $params[':searchTerm'] = "%$searchTerm%";
        }

        $query .= " GROUP BY Anime.ID ORDER BY Anime.Name_Fr ASC";

        $stmt = $pdo->prepare($query);

        // Bind parameters dynamically
        foreach ($params as $key => &$value) {
            $stmt->bindParam($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function getAllAnime($pdo)
{
 
  try {
 
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

    require_once 'pdo.lib.php'; 
    $filteredAnime = filterAnime($studioId, $creatorId, $univerID ,$genres, $searchTerm, $yearMin, $yearMax, $pdo);

    echo json_encode($filteredAnime);
    exit;
  } elseif ($action == "fetchAll") {
    $allAnime = getAllAnime($pdo);

    echo json_encode($allAnime);
    exit;
  }
}

function fetchStudios($pdo)
{
 
  try {

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



function fetchCreator($pdo)
{

  try {

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


function fetchGenres($pdo)
{
 
  try {

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

function fetchUniver($pdo)
{

  try {
 
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
