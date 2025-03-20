<?php
/**
 * Variable PDO de connexion à la bdd

 *
 * @author Guillaume Petit
 * @package default
 */


 $dbHost = 'localhost';
$dbName = 'db_anime';
    $dbUser = 'root';
    $dbPass = 'root';
 
 try {
   $pdo = new PDO('mysql:host=localhost;dbname=db_anime;charset=utf8', 'root', 'root');
  $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die('Erreur de connexion : ' . $e->getMessage());
}