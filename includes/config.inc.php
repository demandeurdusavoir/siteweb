<?php
session_start();
//* chaine de connexion
// mysql : le système SGBD utilisé
// dbname : le nom de la base
// host : l'adresse du serveur

$dsn = 'mysql:dbname=association;host=localhost'; // dsn
$user = 'root'; // utilisateur root universel et super utilisateur
$password = ''; // mot de passe non spécifié ne veux pas dire qu'il doit pas exister ou être utiliser

$conn = new PDO($dsn, $user , $password) or die("Connexion échouée"); // objet de la connexion
