<?php
require_once('connexion.php');

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['add_memory'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $content = $_POST['content'];
        $theme_id = $_POST['theme_id'];
        $domain_id = $_POST['domain_id'];

        $query = "INSERT INTO memoires (titre, auteur, contenu, theme_id, domaine_id) VALUES (:title, :author, :content, :theme_id, :domain_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':theme_id', $theme_id);
        $stmt->bindParam(':domain_id', $domain_id);
        $stmt->execute();
        header("Location: tableau_admin.php");
        exit;
    }
    elseif (isset($_POST['delete_memory'])) {
        $memoire_id = $_POST['memoire_id'];

        $query = "DELETE FROM memoires WHERE id_memoire = :memoire_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':memoire_id', $memoire_id);
        $stmt->execute();
        header("Location: tableau_admin.php");
        exit;
    }
}

$query = "SELECT * FROM memoires";
$stmt = $db->query($query);
$memories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM themes";
$stmt = $db->query($query);
$themes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM domaines";
$stmt = $db->query($query);
$domains = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="style\admin.css">
</head>
<body>
    <header>
        <h1>le Tableau de Bord Administrateur</h1>
    </header>

    <nav>
        <ul>
            <li><a href="Admin.php">Accueil</a></li>
            <li><a href="index.php">Déconnexion</a></li>
        </ul>
    </nav>
    <section class="content">
        <h2>Ajouter une Nouvelle Mémoire</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="title">Titre:</label><br>
            <input type="text" id="title" name="title" required><br>
            <label for="author">Auteur:</label><br>
            <input type="text" id="author" name="author" required><br>
            <label for="content">Contenu:</label><br>
            <textarea id="content" name="content" rows="4" cols="50" required></textarea><br>
            <label for="theme_id">Thème:</label><br>
            <select id="theme_id" name="theme_id" required>
                <?php foreach ($themes as $theme): ?>
                    <option value="<?php echo $theme['id_theme']; ?>"><?php echo $theme['nom_theme']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <label for="domain_id">Domaine:</label><br>
            <select id="domain_id" name="domain_id" required>
                <?php foreach ($domains as $domain): ?>
                    <option value="<?php echo $domain['id_domaine']; ?>"><?php echo $domain['nom_domaine']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <input type="submit" name="add_memory" value="Ajouter Mémoire">
        </form>
        <h2>Liste des Mémoires</h2>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Contenu</th>
                    <th>Thème</th>
                    <th>Domaine</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($memories as $memory): ?>
                <tr>
                    <td><?php echo $memory['titre']; ?></td>
                    <td><?php echo $memory['auteur']; ?></td>
                    <td><?php echo $memory['contenu']; ?></td>
                    <td><?php echo $memory['theme_id']; ?></td>
                    <td><?php echo $memory['domaine_id']; ?></td>
                    <td>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="memoire_id" value="<?php echo $memory['id_memoire']; ?>">
                            <input type="submit" name="delete_memory" value="Supprimer">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>gestion des memoires @ iam.2024</p>
    </footer>
</body>
</html>