<?php

$host = 'localhost'; 
$dbname = 'memo';
$username = 'root';
$password = ''; 


try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}
?>