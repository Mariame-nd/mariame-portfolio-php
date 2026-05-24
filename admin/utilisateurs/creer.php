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

    $prenom = nettoyer($_POST['prenom'] ?? '');
    $nom    = nettoyer($_POST['nom']    ?? '');
    $email  = nettoyer($_POST['email']  ?? '');
    $mdp    = $_POST['mot_de_passe']    ?? '';

    if (empty($prenom)) $erreurs[] = "Le prénom est obligatoire.";
    if (empty($nom))    $erreurs[] = "Le nom est obligatoire.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs[] = "Email invalide.";
    if (strlen($mdp) < 6) $erreurs[] = "Le mot de passe doit faire au moins 6 caractères.";

    if (empty($erreurs)) {
        $hash = password_hash($mdp, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO administrateurs (prenom, nom, email, mot_de_passe) VALUES (?, ?, ?, ?)');
        $stmt->execute([$prenom, $nom, $email, $hash]);
        $succes = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un administrateur</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Ajouter un administrateur</h1>
        <a href="liste.php">← Retour à la liste</a>

        <?php if ($succes): ?>
            <p style="color: #00ff00;">Administrateur créé avec succès !</p>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div style="color: #ff4444;">
                <?php foreach ($erreurs as $err): ?>
                    <p>• <?= e($err) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="creer.php">
            <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Créer l'administrateur</button>
        </form>
    </div>
</body>
</html>