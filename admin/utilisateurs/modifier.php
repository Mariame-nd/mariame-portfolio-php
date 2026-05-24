<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM administrateurs WHERE id = ?');
$stmt->execute([$id]);
$admin = $stmt->fetch();

if (!$admin) {
    header('Location: liste.php');
    exit;
}

$erreurs = [];
$succes  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifier_token_csrf($_POST['csrf_token'] ?? '');

    $prenom = nettoyer($_POST['prenom'] ?? '');
    $nom    = nettoyer($_POST['nom']    ?? '');
    $email  = nettoyer($_POST['email']  ?? '');
    $mdp    = $_POST['mot_de_passe']    ?? '';

    if (empty($prenom)) $erreurs[] = "Le prénom est obligatoire.";
    if (empty($nom))    $erreurs[] = "Le nom est obligatoire.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs[] = "Email invalide.";

    if (empty($erreurs)) {
        if (!empty($mdp)) {
            $hash = password_hash($mdp, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('UPDATE administrateurs SET prenom = ?, nom = ?, email = ?, mot_de_passe = ? WHERE id = ?');
            $stmt->execute([$prenom, $nom, $email, $hash, $id]);
        } else {
            $stmt = $pdo->prepare('UPDATE administrateurs SET prenom = ?, nom = ?, email = ? WHERE id = ?');
            $stmt->execute([$prenom, $nom, $email, $id]);
        }
        $succes = true;
        $admin['prenom'] = $prenom;
        $admin['nom']    = $nom;
        $admin['email']  = $email;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un administrateur</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Modifier l'administrateur</h1>
        <a href="liste.php">← Retour à la liste</a>

        <?php if ($succes): ?>
            <p style="color: #00ff00;">Administrateur modifié avec succès !</p>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div style="color: #ff4444;">
                <?php foreach ($erreurs as $err): ?>
                    <p>• <?= e($err) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="modifier.php?id=<?= $id ?>">
            <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
            <input type="text" name="prenom" value="<?= e($admin['prenom']) ?>" required>
            <input type="text" name="nom" value="<?= e($admin['nom']) ?>" required>
            <input type="email" name="email" value="<?= e($admin['email']) ?>" required>
            <input type="password" name="mot_de_passe" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)">
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>
</html>