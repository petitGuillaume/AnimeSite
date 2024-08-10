<?php
/**
 * Variable PDO de connexion à la bdd

 *
 * @author Guillaume Petit
 * @package default
 */

$conn = new PDO('mysql:host=localhost;dbname=db_anime;charset=utf8', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
