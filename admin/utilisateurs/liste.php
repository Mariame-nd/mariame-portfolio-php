<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$admins = $pdo->query('SELECT id, prenom, nom, email, date_creation FROM administrateurs ORDER BY date_creation DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des administrateurs</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Gestion des administrateurs</h1>
        <a href="creer.php">+ Ajouter un administrateur</a>
        <a href="../dashboard.php">← Retour au dashboard</a>

        <table>
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= e($admin['prenom']) ?></td>
                    <td><?= e($admin['nom']) ?></td>
                    <td><?= e($admin['email']) ?></td>
                    <td><?= e($admin['date_creation']) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $admin['id'] ?>">Modifier</a>
                        <?php if ($admin['id'] !== $_SESSION['admin_id']): ?>
                        <form method="POST" action="supprimer.php" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
                            <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                            <button type="submit" onclick="return confirm('Supprimer cet administrateur ?')">Supprimer</button>
                        </form>
                        <?php else: ?>
                            <span style="color: gray;">Votre compte</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>