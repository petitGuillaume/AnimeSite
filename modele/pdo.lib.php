<?php
/**
 * Connexion à la base de données avec PDO
 *
 * @author Guillaume Petit
 */

$dbHost = 'localhost';
$dbName = 'db_anime';
$dbUser = 'root';
$dbPass = 'root';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Affichage simplifié pour éviter d'exposer des informations sensibles
    error_log('Erreur de connexion à la BDD : ' . $e->getMessage());
    exit('Erreur de connexion à la base de données. Veuillez réessayer plus tard.');
}