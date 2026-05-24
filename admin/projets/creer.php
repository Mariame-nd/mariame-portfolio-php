<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$erreurs = [];
$succes  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifier_token_csrf($_POST['csrf_token'] ?? '');

    $titre        = nettoyer($_POST['titre']        ?? '');
    $description  = nettoyer($_POST['description']  ?? '');
    $technologies = nettoyer($_POST['technologies'] ?? '');
    $lien         = nettoyer($_POST['lien']         ?? '');
    $image        = null;

    if (empty($titre))        $erreurs[] = "Le titre est obligatoire.";
    if (empty($description))  $erreurs[] = "La description est obligatoire.";
    if (empty($technologies)) $erreurs[] = "Les technologies sont obligatoires.";

    // Upload image
    if (!empty($_FILES['image']['name'])) {
        $ext_autorisees = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $ext_autorisees)) {
            $erreurs[] = "Format d'image non autorisé (jpg, jpeg, png, webp, gif).";
        } else {
            $nom_fichier = uniqid('projet_') . '.' . $ext;
            $destination = __DIR__ . '/../../images/projets/' . $nom_fichier;
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            $image = $nom_fichier;
        }
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare('INSERT INTO projets (titre, description, technologies, image, lien) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$titre, $description, $technologies, $image, $lien]);
        $succes = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un projet</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Ajouter un projet</h1>
        <a href="liste.php">← Retour à la liste</a>

        <?php if ($succes): ?>
            <p style="color: #00ff00;">Projet ajouté avec succès !</p>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div style="color: #ff4444;">
                <?php foreach ($erreurs as $e): ?>
                    <p>• <?= e($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="creer.php" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
            <input type="text" name="titre" placeholder="Titre du projet" required>
            <textarea name="description" placeholder="Description" rows="4" required></textarea>
            <input type="text" name="technologies" placeholder="Technologies (ex: PHP, MySQL, CSS)">
            <input type="url" name="lien" placeholder="Lien externe (optionnel)">
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,.gif">
            <button type="submit">Ajouter le projet</button>
        </form>
    </div>
</body>
</html>