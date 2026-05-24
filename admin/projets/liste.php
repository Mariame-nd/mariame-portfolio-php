<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$projets = $pdo->query('SELECT * FROM projets ORDER BY date_creation DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des projets</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Gestion des projets</h1>

        <a href="creer.php">+ Ajouter un projet</a>
        <a href="../dashboard.php">← Retour au dashboard</a>

        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Technologies</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projets as $projet): ?>
                <tr>
                    <td><?= e($projet['titre']) ?></td>
                    <td><?= e($projet['technologies']) ?></td>
                    <td><?= e($projet['date_creation']) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $projet['id'] ?>">Modifier</a>
                        <form method="POST" action="supprimer.php" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
                            <input type="hidden" name="id" value="<?= $projet['id'] ?>">
                            <button type="submit" onclick="return confirm('Supprimer ce projet ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>