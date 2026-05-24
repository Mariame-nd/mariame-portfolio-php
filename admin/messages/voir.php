<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM messages_contact WHERE id = ?');
$stmt->execute([$id]);
$msg = $stmt->fetch();

if (!$msg) {
    header('Location: liste.php');
    exit;
}

// Marquer comme lu
if ($msg['lu'] == 0) {
    $stmt = $pdo->prepare('UPDATE messages_contact SET lu = 1 WHERE id = ?');
    $stmt->execute([$id]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message de <?= e($msg['nom']) ?></title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Message de <?= e($msg['nom']) ?></h1>
        <a href="liste.php">← Retour aux messages</a>

        <div style="margin-top: 20px;">
            <p><strong>Nom :</strong> <?= e($msg['nom']) ?></p>
            <p><strong>Email :</strong> <?= e($msg['email']) ?></p>
            <p><strong>Date :</strong> <?= e($msg['date_envoi']) ?></p>
            <p><strong>Message :</strong></p>
            <p style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px;">
                <?= nl2br(e($msg['message'])) ?>
            </p>
        </div>
    </div>
</body>
</html>