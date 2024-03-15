<?php
require_once('connexion.php');

$query_themes = "SELECT * FROM themes";
$stmt_themes = $db->query($query_themes);
$themes = $stmt_themes->fetchAll(PDO::FETCH_ASSOC);

$query_domains = "SELECT * FROM domaines";
$stmt_domains = $db->query($query_domains);
$domains = $stmt_domains->fetchAll(PDO::FETCH_ASSOC);

$content = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['search'])) {
        $theme_id = $_POST['theme_id'];
        $domain_id = $_POST['domain_id'];

        $query = "SELECT * FROM memoires WHERE theme_id = :theme_id AND domaine_id = :domain_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':theme_id', $theme_id);
        $stmt->bindParam(':domain_id', $domain_id);
        $stmt->execute();
        $memory = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($memory) {
            $content = $memory['contenu'];
        } else {
            $content = "Aucune mémoire correspondante trouvée.";
        }
    }

    if (isset($_POST['download'])) {
        $content = $_POST['content'];
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="memoire.txt"');
        echo $content;
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche et Téléchargement de Mémoires</title>
    <link rel="stylesheet" href="style\rechercher_telecharger.css">
</head>
<body>
    <header>
        <h1>Recherche et Téléchargement de Mémoires</h1>
    </header>

    <section class="content">
        <h2>Rechercher des Mémoires</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="theme_id">Thème:</label>
            <select id="theme_id" name="theme_id" required>
                <?php foreach ($themes as $theme): ?>
                    <option value="<?php echo $theme['id_theme']; ?>"><?php echo $theme['nom_theme']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <label for="domain_id">Domaine:</label>
            <select id="domain_id" name="domain_id" required>
                <?php foreach ($domains as $domain): ?>
                    <option value="<?php echo $domain['id_domaine']; ?>"><?php echo $domain['nom_domaine']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <input type="submit" name="search" value="Télécharger">
        </form>
        <?php if($content): ?>
            <h2>Résultats de la Recherche</h2>
            <div>
                <?php echo $content; ?>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="content" value="<?php echo $content; ?>">
                <input type="submit" name="download" value="Télécharger">
            </form>
        <?php endif; ?>
    </section>

    <footer>
    <li><a href="index.php">Déconnexion</a></li>
        <p>gestion des memoires @ iam.2024</p>
    </footer>
</body>
</html>