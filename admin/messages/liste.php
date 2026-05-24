<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$messages = $pdo->query('SELECT * FROM messages_contact ORDER BY date_envoi DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages de contact</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Messages de contact</h1>
        <a href="../dashboard.php">← Retour au dashboard</a>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                <tr style="<?= $msg['lu'] == 0 ? 'font-weight: bold;' : 'opacity: 0.6;' ?>">
                    <td><?= e($msg['nom']) ?></td>
                    <td><?= e($msg['email']) ?></td>
                    <td>
                        <a href="voir.php?id=<?= $msg['id'] ?>">
                            <?= e(substr($msg['message'], 0, 50)) ?>...
                        </a>
                    </td>
                    <td><?= e($msg['date_envoi']) ?></td>
                    <td><?= $msg['lu'] == 0 ? '🔴 Non lu' : '✅ Lu' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>