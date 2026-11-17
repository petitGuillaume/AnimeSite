<!DOCTYPE html>
<?php
    
        session_start();
            include_once ("Vue/navbar.inc.php");
            include_once ("modele/pdo.lib.php");
           

 /*  */
        
$page = array_key_first($_GET) ?? 'home';

switch ($page) {
    case 'anime':
        include_once('controleur/anime.inc.php');
        break;

    case 'film':
        include_once('controleur/film.inc.php');
        break;

    case 'rajout_anime':
        include_once('controleur/rajout_anime.inc.php');
        break;

    case 'modif_anime':
        include_once('controleur/modif_anime.inc.php');
        break;

    case 'detail_anime':
        include_once('controleur/detail_anime.inc.php');
        break;

    case 'detail_film':
        include_once('controleur/detail_film.inc.php');
        break;

    default:
        include_once('controleur/home.inc.php');
        break;
}
?>

