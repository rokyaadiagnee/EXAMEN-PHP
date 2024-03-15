<?php
require_once('connexion.php');
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != "etudiant") {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étudiant</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        header {
            color: #f07909;
            padding: 20px 0;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            text-decoration: none;
            color: #333;
        }
        nav ul li a:hover {
            color: #f07909;
        }
        .content {
            width: 80%;
            margin: 20px auto;
            text-align: justify;
        }
        footer {
            color: #f07909;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        
    </style>
</head>
<body>
    <header>
        <h1>Bienvenue sur notre site!</h1>
    </header>

    <nav>
        <ul>
            <li><a href="Etudiant.php">Accueil</a></li>
            <li><a href="recherche_telecharger.php">Mémoires</a></li>
            <li><a href="index.php">Déconnexion</a></li>
        </ul>
    </nav>

    <section class="content">
        <p>Bienvenue sur notre page d'accueil dédiée à la gestion des mémoires ! Nous sommes ravis de vous accueillir dans notre espace. Que vous soyez des étudiants en Licence 3 ou en Master 2, vous êtes au bon endroit.</p>
        <p>Notre site offre aux administrateurs et aux étudiants la possibilité d'archiver et d'organiser les mémoires par thèmes et domaines pour vous aider à gérer efficacement vos mémoires.</p>
        <p><a href="recherche_telecharger.php">Rechercher et télécharger des mémoires</a></p>
    </section>

    <footer>
        <p>gestion des memoires @ iam.2024</p>
    </footer>
</body>
</html>