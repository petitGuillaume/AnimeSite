<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="Navbar.css">


<?php
    
        session_start();
            include_once ("Vue/navbar.inc.php");
            include_once ("modele/pdo.lib.php");
           

 /*  */
        
        if (isset($_GET['anime'])){
            include_once ('controleur/anime.inc.php');
        }else if (isset($_GET['film'])){
            include_once ('controleur/film.inc.php');
        }
         else if (isset($_GET['rajout_anime'])){
            include_once ('controleur/rajout_anime.inc.php');
        }
         else if (isset($_GET['detail'])){
            include_once ('controleur/detail_anime.inc.php');
        }

        ?>
        

