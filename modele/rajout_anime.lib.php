<?php
// insert_anime.php
include_once("modele/pdo.lib.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['form_type'] === 'add_anime') {

        // Nettoyez et validez les entrées utilisateur
        $name_jp = $_POST['name_jp'];
        $name_fr = $_POST['name_fr'];
        $image = $_FILES['image']['name'];
        $synopsis = $_POST['synopsis'];
        $year = intval($_POST['year']);
        $nb_episodes = intval($_POST['nb_episodes']);
        $nb_oav = intval($_POST['nb_oav']);
        $nb_film = intval($_POST['nb_film']);
        $id_univers = intval($_POST['id_univers']);
        $id_source = isset($_POST['id_source']) ? intval($_POST['id_source']) : null;
        $anime_type = $_POST['anime_type'];
        $id_studio = intval($_POST['id_studio']);
        $id_createur = intval($_POST['id_createur']);


        $imageFileName = $_FILES['image']['name'];
        $imageTempPath = $_FILES['image']['tmp_name'];


        // Insérez les données de l'anime dans la table "Anime" en utilisant le lien de paramètres
        $sql = "INSERT INTO Anime (Name_Jp, Name_Fr, image, Synopsis, Year, Nb_episodes, Nb_OAV, Nb_Film, ID_univers, ID_Source, Anime_Type, ID_studio, ID_createur) 
                VALUES (:name_jp, :name_fr, :image, :synopsis, :year, :nb_episodes, :nb_oav, :nb_film, :id_univers, :id_source, :anime_type, :id_studio, :id_createur)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name_jp', $name_jp);
        $stmt->bindParam(':name_fr', $name_fr);
        $stmt->bindParam(':image', $imageFileName);
        $stmt->bindParam(':synopsis', $synopsis);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':nb_episodes', $nb_episodes, PDO::PARAM_INT);
        $stmt->bindParam(':nb_oav', $nb_oav, PDO::PARAM_INT);
        $stmt->bindParam(':nb_film', $nb_film, PDO::PARAM_INT);
        $stmt->bindParam(':id_univers', $id_univers, PDO::PARAM_INT);
        $stmt->bindParam(':id_source', $id_source, PDO::PARAM_INT);
        $stmt->bindParam(':anime_type', $anime_type);
        $stmt->bindParam(':id_studio', $id_studio, PDO::PARAM_INT);
        $stmt->bindParam(':id_createur', $id_createur, PDO::PARAM_INT);

        $targetPath = 'ressource/img/anime_img/' . $imageFileName;
        move_uploaded_file($imageTempPath, $targetPath);

        if ($stmt->execute()) {
            echo "Enregistrement de l'anime inséré avec succès.";
            $anime_id = $conn->lastInsertId(); // Obtenez l'ID du dernier anime inséré

            // Insérez les relations anime-genre dans la table "Anime_Genres"
            if (isset($_POST['genres']) && is_array($_POST['genres'])) {
                $genres = $_POST['genres'];
                foreach ($genres as $genre_id) {
                    // Préparez la requête SQL avec des paramètres pour éviter les injections SQL
                    $genre_id = intval($genre_id);
                    $sql = "INSERT INTO Anime_Genres (ID_Anime, ID_Genre) VALUES (:anime_id, :genre_id)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':anime_id', $anime_id, PDO::PARAM_INT);
                    $stmt->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        echo "Relation Anime-Genre insérée avec succès.";
                    } else {
                        echo "Erreur lors de l'insertion de la relation Anime-Genre : " . $pdo->errorInfo()[2];
                    }
                }
            }
        } else {
            echo "Erreur lors de l'insertion de l'enregistrement de l'anime : " . $pdo->errorInfo()[2];
        }
    } elseif ($_POST['form_type'] === 'add_film') {

        // Nettoyez et validez les entrées utilisateur
        $name_jp = $_POST['name_jp'];
        $name_fr = $_POST['name_fr'];
        $image = $_FILES['image']['name'];    
        $synopsis = $_POST['synopsis_film'];
        $year = intval($_POST['year_film']);
        $id_univers = intval($_POST['id_univers']);
        $id_source = isset($_POST['id_source']) ? intval($_POST['id_source']) : null;
        $id_studio = intval($_POST['id_studio']);
        $id_createur = intval($_POST['id_createur']);

        $imageFileName = $_FILES['image']['name'];
        $imageTempPath = $_FILES['image']['tmp_name'];

        // Insérez les données de l'anime dans la table "Anime" en utilisant le lien de paramètres
        $sql = "INSERT INTO film (Name_Jp, Name_Fr, image, Synopsis, Year, ID_univers, ID_Source, ID_studio, ID_createur) 
            VALUES (:name_jp, :name_fr, :image, :synopsis, :year, :id_univers, :id_source, :id_studio, :id_createur)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name_jp', $name_jp);
        $stmt->bindParam(':name_fr', $name_fr);
        $stmt->bindParam(':image', $imageFileName);
        $stmt->bindParam(':synopsis', $synopsis);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':id_univers', $id_univers, PDO::PARAM_INT);
        $stmt->bindParam(':id_source', $id_source, PDO::PARAM_INT);
        $stmt->bindParam(':id_studio', $id_studio, PDO::PARAM_INT);
        $stmt->bindParam(':id_createur', $id_createur, PDO::PARAM_INT);

         $targetPath = 'ressource/img/film_img/' . $imageFileName;
        move_uploaded_file($imageTempPath, $targetPath);
        
        
        if ($stmt->execute()) {
            echo "Enregistrement de du film inséré avec succès.";
            $film_id = $conn->lastInsertId(); // Obtenez l'ID du dernier anime inséré

            // Insérez les relations anime-genre dans la table "Anime_Genres"
            if (isset($_POST['genres']) && is_array($_POST['genres'])) {
                $genres = $_POST['genres'];
                foreach ($genres as $genre_id) {
                    // Préparez la requête SQL avec des paramètres pour éviter les injections SQL
                    $genre_id = intval($genre_id);
                    $sql = "INSERT INTO film_Genres (ID_film, ID_Genre) VALUES (:film_id, :genre_id)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':film_id', $film_id, PDO::PARAM_INT);
                    $stmt->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        echo "Relation film-Genre insérée avec succès.";
                    } else {
                        echo "Erreur lors de l'insertion de la relation Anime-Genre : " . $pdo->errorInfo()[2];
                    }
                }
            }
        } else {
            echo "Erreur lors de l'insertion de l'enregistrement de l'anime : " . $pdo->errorInfo()[2];
        }
    } elseif ($_POST['form_type'] === 'add_genre') {
        // Récupération du nom du genre depuis le formulaire
        $genre_name = $_POST['genre_name'];

        // Vérification si le genre existe déjà dans la table "Genres"
        $sql_check_genre = "SELECT * FROM Genres WHERE name = :genre_name";
        $stmt_check_genre = $conn->prepare($sql_check_genre);
        $stmt_check_genre->bindParam(':genre_name', $genre_name, PDO::PARAM_STR);
        $stmt_check_genre->execute();

        if ($stmt_check_genre->rowCount() > 0) {
            echo "Le genre existe déjà dans la base de données.";
        } else {
            // Insérer le genre dans la table "Genres" en utilisant une requête préparée
            $sql_insert_genre = "INSERT INTO Genres (name) VALUES (:genre_name)";
            $stmt_insert_genre = $conn->prepare($sql_insert_genre);
            $stmt_insert_genre->bindParam(':genre_name', $genre_name, PDO::PARAM_STR);

            if ($stmt_insert_genre->execute()) {
                echo "Le genre a été ajouté avec succès !";
            } else {
                echo "Erreur lors de l'insertion du genre : " . $stmt_insert_genre->errorInfo()[2];
            }
        }
    } elseif ($_POST['form_type'] === 'add_univers') {
        // Récupération du nom du genre depuis le formulaire
        $univers_name = $_POST['univers_name'];

        // Vérification si le univers existe déjà dans la table "univers"
        $sql_check_univers = "SELECT * FROM `univers`  WHERE name = :univers_name ";
        $stmt_check_univers = $conn->prepare($sql_check_univers);
        $stmt_check_univers->bindParam(':univers_name', $univers_name, PDO::PARAM_STR);
        $stmt_check_univers->execute();

        if ($stmt_check_univers->rowCount() > 0) {
            echo "Le genre existe déjà dans la base de données.";
        } else {
            // Insérer l'univers dans la table "univers" en utilisant une requête préparée
            $sql_insert_univers = "INSERT INTO univers (name) VALUES (:univers_name)";
            $stmt_insert_univers = $conn->prepare($sql_insert_univers);
            $stmt_insert_univers->bindParam(':univers_name', $univers_name, PDO::PARAM_STR);

            if ($stmt_insert_univers->execute()) {
                echo "L'univers a été ajouté avec succès !";
            } else {
                echo "Erreur lors de l'insertion du univers : " . $stmt_insert_univers->errorInfo()[2];
            }
        }
    } elseif ($_POST['form_type'] === 'add_studios') {
        // Récupération du nom du genre depuis le formulaire
        $studios_name = $_POST['studios_name'];

        // Vérification si le univers existe déjà dans la table "univers"
        $sql_check_studios = "SELECT * FROM `studios`  WHERE name = :studios_name";
        $stmt_check_studios = $conn->prepare($sql_check_studios);
        $stmt_check_studios->bindParam(':studios_name', $studios_name, PDO::PARAM_STR);
        $stmt_check_studios->execute();

        if ($stmt_check_studios->rowCount() > 0) {
            echo "Le genre existe déjà dans la base de données.";
        } else {
            // Insérer l'univers dans la table "univers" en utilisant une requête préparée
            $sql_insert_studios = "INSERT INTO studios (name) VALUES (:studios_name)";
            $stmt_insert_studios = $conn->prepare($sql_insert_studios);
            $stmt_insert_studios->bindParam(':studios_name', $studios_name, PDO::PARAM_STR);

            if ($stmt_insert_studios->execute()) {
                echo "Le studios a été ajouté avec succès !";
            } else {
                echo "Erreur lors de l'insertion du studios : " . $stmt_insert_studios->errorInfo()[2];
            }
        }
    } elseif ($_POST['form_type'] === 'add_createur') {
        // Récupération du nom du genre depuis le formulaire
        $createur_name = $_POST['createur_name'];

        // Vérification si le univers existe déjà dans la table "univers"
        $sql_check_createur = "SELECT * FROM `createurs`  WHERE name = :createur_name";
        $stmt_check_createur = $conn->prepare($sql_check_createur);
        $stmt_check_createur->bindParam(':createur_name', $studios_name, PDO::PARAM_STR);
        $stmt_check_createur->execute();

        if ($stmt_check_createur->rowCount() > 0) {
            echo "Le genre existe déjà dans la base de données.";
        } else {
            // Insérer l'univers dans la table "univers" en utilisant une requête préparée
            $sql_insert_createur = "INSERT INTO createurs (name) VALUES (:createur_name)";
            $stmt_insert_createur = $conn->prepare($sql_insert_createur);
            $stmt_insert_createur->bindParam(':createur_name', $createur_name, PDO::PARAM_STR);

            if ($stmt_insert_createur->execute()) {
                echo "Le createur a été ajouté avec succès !";
            } else {
                echo "Erreur lors de l'insertion du createur : " . $stmt_insert_createur->errorInfo()[2];
            }
        }
    }


}
