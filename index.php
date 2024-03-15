<?php
require_once('connexion.php');

// Initialisation de la variable d'erreur
$error_message = '';

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête pour récupérer l'utilisateur à partir de la base de données
    $query = "SELECT * FROM utilisateurs WHERE nom_utilisateur = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification de l'utilisateur et du mot de passe
    if ($user) {
        if ($password === $user['mot_de_passe']) {
            // Démarrage de la session et enregistrement des données de l'utilisateur
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['nom_utilisateur'];
            $_SESSION['role'] = $user['role'];

            // Redirection en fonction du rôle de l'utilisateur
            if ($user['role'] == 'Admin') {
                header("Location: Admin.php");
                exit;
            } elseif ($user['role'] == 'Etudiant') {
                header("Location: Etudiant.php");
                exit;
            }
        } else {
            $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error_message = "L'utilisateur n'existe pas dans la base de données.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        /* Début du style CSS */
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
.login-form {
    width: 320px; /* Augmenté de 20px pour tenir compte de la bordure */
    margin: 50px auto 0; /* Modifié pour garder la marge en haut uniquement */
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc; /* Ajouté une bordure */
    border-radius: 5px;
    box-shadow: 0 0 10px black;
}
label {
    display: block;
    margin-bottom: 5px;
}
input[type="text"],
input[type="password"] {
    width: calc(100% - 22px); /* Ajusté la largeur pour compenser la bordure */
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
input[type="submit"] {
    width: calc(100% - 22px); /* Ajusté la largeur pour compenser la bordure */
    padding: 10px;
    background-color: #f07909;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
input[type="submit"]:hover {
    background-color: #555;
}
.error {
    color: red;
    margin-top: 10px;
}
footer {
    color: #f07909;
    text-align: center;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
}

        /* Fin du style CSS */
    </style>
</head>
<body>
    <header>
        <h1>Connexion</h1>
    </header>
    
    <section class="login-form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Nom d'utilisateur:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Mot de passe:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Se Connecter">
        </form>
        <?php if(isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </section>
    <footer>
        <p> gestion des memoires @ iam.2024.</p>
    </footer>
</body>
</html>