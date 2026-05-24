<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM demandes_projet WHERE id = ?');
$stmt->execute([$id]);
$demande = $stmt->fetch();

if (!$demande) {
    header('Location: liste.php');
    exit;
}

// Marquer comme lu
if ($demande['lu'] == 0) {
    $stmt = $pdo->prepare('UPDATE demandes_projet SET lu = 1 WHERE id = ?');
    $stmt->execute([$id]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de <?= e($demande['nom']) ?></title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Demande de <?= e($demande['nom']) ?></h1>
        <a href="liste.php">← Retour aux demandes</a>

        <div style="margin-top: 20px;">
            <p><strong>Nom :</strong> <?= e($demande['nom']) ?></p>
            <p><strong>Email :</strong> <?= e($demande['email']) ?></p>
            <p><strong>Type de projet :</strong> <?= e($demande['type_projet']) ?></p>
            <p><strong>Budget :</strong> <?= e($demande['budget'] ?? 'Non renseigné') ?></p>
            <p><strong>Date :</strong> <?= e($demande['date_demande']) ?></p>
            <p><strong>Description :</strong></p>
            <p style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px;">
                <?= nl2br(e($demande['description'])) ?>
            </p>
        </div>
    </div>
</body>
</html>