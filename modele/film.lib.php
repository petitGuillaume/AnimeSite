<?php

// Function to fetch anime data from the database based on filters and search term
function filterAnime($studioId, $creatorId, $univerID, $genres, $searchTerm, $yearMin, $yearMax)
{
  // Implement your database connection and query here
  // Replace the placeholders with the actual database credentials
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';
  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Build the query based on the filters and search term
    $query = "SELECT Film.*,
    Studios.Name AS StudioName,
    univers.Name AS UniverseName,
    Createurs.Name AS CreatorName,
    GROUP_CONCAT(Genres.name SEPARATOR ', ') AS GenresList
FROM film
LEFT JOIN Studios ON Film.ID_studio = Studios.ID
LEFT JOIN univers ON Film.ID_univers = univers.ID
LEFT JOIN Createurs ON Film.Id_createur = Createurs.ID
LEFT JOIN film_genres ON Film.ID = film_genres.ID_film
LEFT JOIN Genres ON film_genres.ID_genre = Genres.ID
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

  $query .= " AND ID_film IN (
    SELECT ID_film
    FROM film_genres
    WHERE ID_Genre IN ($genreIds)
    GROUP BY ID_film
    HAVING COUNT(DISTINCT ID_Genre) = $numGenres
  )";  }

    if (!empty($searchTerm)) {
      $query .= " AND (Name_Jp LIKE :searchTerm OR Name_Fr LIKE :searchTerm)  GROUP BY Film.ID, Studios.Name, univers.Name, Createurs.Name";
    }
    else{
      $query .= " GROUP BY Film.ID, Studios.Name, univers.Name, Createurs.Name ORDER BY  film.Name_Fr ASC";
    }

    // Prepare the query
    $stmt = $pdo->prepare($query);

    // Bind the parameters
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
    // Execute the query
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return false;
  }
}

// Function to fetch all anime data from the database
function getAllAnime()
{
  // Implement your database connection and query here
  // Replace the placeholders with the actual database credentials
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';

  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all anime data
    $query = "SELECT * FROM film";
    $stmt = $pdo->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return false;
  }
}

// Process the filtering and searching based on the received form data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
  // Include the film.lib.php file to access its functions
  include_once('film.lib.php');

  // Perform filtering and searching based on the action type
  $action = $_POST["action"];

  if ($action == "filter") {
    // Fetch form data
    $studioId = isset($_POST["studioId"]) ? $_POST["studioId"] : null;
    $creatorId = isset($_POST["creatorId"]) ? $_POST["creatorId"] : null;
    $univerID = isset($_POST["univerID"]) ? $_POST["univerID"] : null;
    $yearMin = isset($_POST["yearMin"]) ? $_POST["yearMin"] : null;
    $yearMax = isset($_POST["yearMax"]) ? $_POST["yearMax"] : null;

    $genres = isset($_POST["genres"]) ? $_POST["genres"] : array();
    $searchTerm = isset($_POST["searchTerm"]) ? $_POST["searchTerm"] : null;

    // Filter anime data based on form inputs
    $filteredAnime = filterAnime($studioId, $creatorId, $univerID ,$genres, $searchTerm, $yearMin, $yearMax);

    // Return the filtered anime data as JSON response
    echo json_encode($filteredAnime);
    exit;
  } elseif ($action == "fetchAll") {
    // Fetch all anime data
    $allAnime = getAllAnime();

    // Return all anime data as JSON response
    echo json_encode($allAnime);
    exit;
  }
}

function fetchStudios()
{
  // Replace with your actual database connection code
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';

  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch studio data
    $query = "SELECT s.ID, s.Name FROM Studios s WHERE EXISTS (
      SELECT *
      FROM film f
      WHERE f.ID_studio = s.ID
      GROUP BY f.ID_studio
  ) order by Name asc";
    $stmt = $pdo->query($query);
    $studios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $studios;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return array(); // Return an empty array in case of an error
  }
}



function fetchCreator()
{
  // Replace with your actual database connection code
  $dbHost = 'localhost';
  $dbName = 'db_anime';
  $dbUser = 'root';
  $dbPass = '';

  try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Corrected Query to fetch creators data
    $query = "SELECT c.ID, c.Name 
              FROM createurs c 
              WHERE EXISTS (
                SELECT * 
                FROM film f 
                WHERE f.Id_createur = c.ID
                GROUP BY f.Id_createur
              ) 
              ORDER BY c.Name ASC";
    $stmt = $pdo->query($query);
    $creators = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $creators;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return array(); // Return an empty array in case of an error
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
        FROM film f
        WHERE f.ID_Univers  = u.ID
        GROUP BY f.ID_Univers 
        HAVING COUNT(*) >= 1) order by u.name asc" ;
    $stmt = $pdo->query($query);
    $univers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $univers;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return array(); // Return an empty array in case of an error
  }
}
