<?php
session_start();
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../fonctions.php';

// Si déjà connecté → rediriger vers dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifier_token_csrf($_POST['csrf_token'] ?? '');

    $email = nettoyer($_POST['email'] ?? '');
    $mdp   = $_POST['mot_de_passe'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM administrateurs WHERE email = ?');
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($mdp, $admin['mot_de_passe'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id']     = $admin['id'];
        $_SESSION['admin_prenom'] = $admin['prenom'];
        header('Location: dashboard.php');
        exit;
    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-login">
        <h1>Espace Administration</h1>

        <?php if ($erreur): ?>
            <p style="color: #ff4444;"><?= e($erreur) ?></p>
        <?php endif; ?>

        <form method="POST" action="connexion.php">
            <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>