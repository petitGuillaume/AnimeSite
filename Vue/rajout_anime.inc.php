<!DOCTYPE html>
<html>

<head>
  <title>Rajout Anime</title>
  <link href="ressource/css/rajout_anime.css" rel="stylesheet">

</head>

<body>
    <div class="FormPage">
        <div class="firstLignRajout">
        <div class="form-item">
            <h2>Ajouter un nouvel Anime</h2>

            <form method="post" action="index.php?rajout_anime" enctype="multipart/form-data">
                <div class="firstBlock">
                    <div class="middle">
                        <label>Nom (Japonais):</label>
                        <input type="text" name="name_jp" required><br>

                        <label>Nom (Français):</label>
                        <input type="text" name="name_fr" required><br>

                        <label>Image:</label>
                        <input type="file" name="image" accept=".png, .jpg, .jpeg" required><br>
                    </div>
                    <div class="middle">
                        <label>Synopsis:</label>
                        <textarea name="synopsis" required></textarea><br>

                        <label>Year:</label>
                        <input type="number" name="year" value="1950" required><br>
                    </div>
                </div>

                <div class="firstBlock">
                    <div class="middle">

                        <label>Nombre d'Episodes:</label>
                        <input type="number" name="nb_episodes" min="0" value="0" required><br>

                        <label>Nombre d'OAV:</label>
                        <input type="number" name="nb_oav" min="0" value="0" required><br>

                        <label>Nombre de Films:</label>
                        <input type="number" name="nb_film" min="0" value="0" required><br>
                    </div>

                    <div class="middle">

                        <label>Univers:</label>
                        <select name="id_univers" required>
                            <option value="">Select an option</option>
                            <!-- Populate options with univers from the database -->
                            <?php
                            // Database connection parameters
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "db_anime";

                            // Create connection
                            $conn = mysqli_connect($servername, $username, $password, $dbname);

                            // Check connection
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            $sql = "SELECT * FROM univers order by name asc";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"{$row['ID']}\">{$row['Name']}</option>";
                            }
                            mysqli_close($conn);
                            ?>
                        </select><br>
                        <label>Studio:</label>
                        <select name="id_studio" required>
                            <option value="">Select an option</option>
                            <!-- Populate options with studios from the database -->
                            <?php
                            // Create connection (if you haven't already)
                            $conn = mysqli_connect($servername, $username, $password, $dbname);

                            // Check connection (if you haven't already)
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            $sql = "SELECT * FROM Studios order by name asc";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"{$row['ID']}\">{$row['Name']}</option>";
                            }
                            mysqli_close($conn);
                            ?>
                        </select><br>
                        <label>créateur:</label>
                        <select name="id_createur" required>
                            <option value="">Select an option</option>
                            <!-- Populate options with studios from the database -->
                            <?php
                            // Create connection (if you haven't already)
                            $conn = mysqli_connect($servername, $username, $password, $dbname);

                            // Check connection (if you haven't already)
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            $sql = "SELECT * FROM createurs order by name asc";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"{$row['ID']}\">{$row['Name']}</option>";
                            }
                            mysqli_close($conn);
                            ?>
                        </select><br>
                    </div>
                </div>


                <label>Source Anime :</label>
                <select name="id_source">
                    <option value="">Select an option</option>
                    <!-- Populate options with anime from the database -->
                    <?php
                    // Create connection (if you haven't already)
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Check connection (if you haven't already)
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM anime order by Name_Fr asc";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$row['ID']}\">{$row['Name_Fr']}</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select><br>

                <label>Anime Type:</label>
                <input type="text" name="anime_type" required><br>



                <label>Genres:</label>
                <div class="BlocGenreRajout">
                    <?php
                    // Create connection (if you haven't already)
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Check connection (if you haven't already)
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM Genres";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
            <div class='MiniBlocGenreRajout'>
            <input type=\"checkbox\" name=\"genres[]\" value=\"{$row['ID']}\"> {$row['name']}</div>";
                    }
                    mysqli_close($conn);
                    ?>
                </div>


                <input type="hidden" name="form_type" value="add_anime">
                <input type="submit" value="Submit">
            </form>
        </div>

        
        <div class="form-item">

            <h2>Add New film</h2>
            <form method="post" action="index.php?rajout_anime" enctype="multipart/form-data">
            <div class="firstBlock">
                    <div class="middle">
                    <label>Nom (Japonais):</label>
                        <input type="text" name="name_jp" required><br>

                        <label>Nom (Français):</label>
                        <input type="text" name="name_fr" required><br><br>

                <label>Image:</label>
                <input type="file" name="image" accept=".png, .jpg, .jpeg" required><br>
                </div>
                <div class="middle">
                    <label>Synopsis:</label>
                    <textarea name="synopsis_film" required></textarea><br>
                
                    
                    <label>Year:</label>
                    <input type="number" name="year_film" required><br>
                </div>
                </div>
                <div class="SecondBlock">
                    <div class="middle">
                <label>Univers:</label>
                <select name="id_univers" required>
                    <option value="">Select an option</option>
                    <!-- Populate options with univers from the database -->
                    <?php
                    // Database connection parameters
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "db_anime";

                    // Create connection
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM univers order by name asc";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$row['ID']}\">{$row['Name']}</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select><br>
                <label>Studio:</label>
                <select name="id_studio" required>
                    <option value="">Select an option</option>
                    <!-- Populate options with studios from the database -->
                    <?php
                    // Create connection (if you haven't already)
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Check connection (if you haven't already)
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM Studios order by name asc";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$row['ID']}\">{$row['Name']}</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select><br>
            <label>créateur:</label>
                <select name="id_createur" required>
                    <option value="">Select an option</option>
                    <!-- Populate options with studios from the database -->
                    <?php
                    // Create connection (if you haven't already)
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Check connection (if you haven't already)
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM createurs order by name asc";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$row['ID']}\">{$row['Name']}</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select><br>
                </div>
                    <div class="middle">
                <label>Source Anime :</label>
                <select name="id_source">
                    <option value="">Select an option</option>
                    <!-- Populate options with anime from the database -->
                    <?php
                    // Create connection (if you haven't already)
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Check connection (if you haven't already)
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM anime order by Name_Fr asc";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$row['ID']}\">{$row['Name_Fr']}</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select><br>

                    </div></div>

                <label>Genres:</label>
                <div class="BlocGenreRajout">
                <?php
                // Create connection (if you haven't already)
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Check connection (if you haven't already)
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM Genres";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='MiniBlocGenreRajout'><input type=\"checkbox\" name=\"genres[]\" value=\"{$row['ID']}\"> {$row['name']}</div>";
                }
                mysqli_close($conn);
                ?>

            </div>

                <input type="hidden" name="form_type" value="add_film">
                <input type="submit" value="Submit">
            </form>

        </div>

        </div>




<div class="SecondLignRajout">
        <div class="form-item">

            <h2>Ajouter un Univers</h2>
            <form action="index.php?rajout_anime" method="post">
                <label>Nom de l'Univers</label>
                <input type="text" name="univers_name" required><br>
                <input type="hidden" name="form_type" value="add_univers">
                <input type="submit" name="submit" value="Ajouter">
            </form>
        </div>

        <div class="form-item">

            <h2>Ajouter un studios</h2>
            <form action="index.php?rajout_anime" method="post">
                <label>Nom du studios:</label>
                <input type="text" name="studios_name" required><br>
                <input type="hidden" name="form_type" value="add_studios">
                <input type="submit" name="submit" value="Ajouter">
            </form>
        </div>
        <div class="form-item">

            <h2>Ajouter un createur</h2>
            <form action="index.php?rajout_anime" method="post">
                <label>Nom du createur:</label>
                <input type="text" name="createur_name" required><br>
                <input type="hidden" name="form_type" value="add_createur">
                <input type="submit" name="submit" value="Ajouter">
            </form>
        </div>

        <div class="form-item">

            <h2>Ajouter un genre</h2>
            <form action="index.php?rajout_anime" method="post">
                <label>Nom du genre:</label>
                <input type="text" name="genre_name" required><br>
                <input type="hidden" name="form_type" value="add_genre">
                <input type="submit" name="submit" value="Ajouter">
            </form>
        </div>
</div>
    </div>

</body>

</html>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.getElementById("fileInput");
        const transferButton = document.getElementById("transferButton");

        transferButton.addEventListener("click", function () {
            const selectedFile = fileInput.files[0];
            if (selectedFile) {
                const formData = new FormData();
                formData.append("file", selectedFile);
                fetch("url_du_script_de_traitement_sur_le_serveur", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Transfert réussi :", data);
                    })
                    .catch(error => {
                        console.error("Erreur de transfert :", error);
                    });
            }
        });
    });
</script>