<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$demandes = $pdo->query('SELECT * FROM demandes_projet ORDER BY date_demande DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de projet</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Demandes de projet</h1>
        <a href="../dashboard.php">← Retour au dashboard</a>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Budget</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $demande): ?>
                <tr style="<?= $demande['lu'] == 0 ? 'font-weight: bold;' : 'opacity: 0.6;' ?>">
                    <td><?= e($demande['nom']) ?></td>
                    <td><?= e($demande['type_projet']) ?></td>
                    <td><?= e($demande['budget'] ?? '-') ?></td>
                    <td><?= e($demande['date_demande']) ?></td>
                    <td>
                        <a href="voir.php?id=<?= $demande['id'] ?>">
                            <?= $demande['lu'] == 0 ? '🔴 Non lu' : '✅ Lu' ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>