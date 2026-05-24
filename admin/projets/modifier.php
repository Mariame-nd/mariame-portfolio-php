<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM projets WHERE id = ?');
$stmt->execute([$id]);
$projet = $stmt->fetch();

if (!$projet) {
    header('Location: liste.php');
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
    $image        = $projet['image'];

    if (empty($titre))        $erreurs[] = "Le titre est obligatoire.";
    if (empty($description))  $erreurs[] = "La description est obligatoire.";
    if (empty($technologies)) $erreurs[] = "Les technologies sont obligatoires.";

    // Upload nouvelle image
    if (!empty($_FILES['image']['name'])) {
        $ext_autorisees = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $ext_autorisees)) {
            $erreurs[] = "Format d'image non autorisé.";
        } else {
            $nom_fichier = uniqid('projet_') . '.' . $ext;
            $destination = __DIR__ . '/../../images/projets/' . $nom_fichier;
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            $image = $nom_fichier;
        }
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare('UPDATE projets SET titre = ?, description = ?, technologies = ?, image = ?, lien = ? WHERE id = ?');
        $stmt->execute([$titre, $description, $technologies, $image, $lien, $id]);
        $succes = true;
        $projet = array_merge($projet, compact('titre', 'description', 'technologies', 'lien', 'image'));
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un projet</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Modifier le projet</h1>
        <a href="liste.php">← Retour à la liste</a>

        <?php if ($succes): ?>
            <p style="color: #00ff00;">Projet modifié avec succès !</p>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div style="color: #ff4444;">
                <?php foreach ($erreurs as $err): ?>
                    <p>• <?= e($err) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="modifier.php?id=<?= $id ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
            <input type="text" name="titre" value="<?= e($projet['titre']) ?>" required>
            <textarea name="description" rows="4" required><?= e($projet['description']) ?></textarea>
            <input type="text" name="technologies" value="<?= e($projet['technologies']) ?>">
            <input type="url" name="lien" value="<?= e($projet['lien'] ?? '') ?>">
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,.gif">
            <?php if ($projet['image']): ?>
                <p>Image actuelle : <?= e($projet['image']) ?></p>
            <?php endif; ?>
            <button type="submit">Modifier le projet</button>
        </form>
    </div>
</body>
</html>