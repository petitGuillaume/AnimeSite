<!DOCTYPE html>
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
        else if (isset($_GET['modif_anime'])){
            include_once ('controleur/modif_anime.inc.php');
        } else if (isset($_GET['detail_anime'])){
            include_once ('controleur/detail_anime.inc.php');
        }else if (isset($_GET['detail_film'])){
            include_once ('controleur/detail_film.inc.php');
        }   else {
            include_once ('controleur/home.inc.php');
        }

        ?>
        

