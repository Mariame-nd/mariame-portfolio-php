<?php
session_start();
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../fonctions.php';

// Vérifier si connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: connexion.php');
    exit;
}

// Statistiques
$nb_projets   = $pdo->query('SELECT COUNT(*) FROM projets')->fetchColumn();
$nb_messages  = $pdo->query('SELECT COUNT(*) FROM messages_contact WHERE lu = 0')->fetchColumn();
$nb_demandes  = $pdo->query('SELECT COUNT(*) FROM demandes_projet WHERE lu = 0')->fetchColumn();

// 5 dernières visites
$visites = $pdo->query('SELECT * FROM visites ORDER BY date_visite DESC LIMIT 5')->fetchAll();

// 5 dernières demandes
$dernieres_demandes = $pdo->query('SELECT * FROM demandes_projet ORDER BY date_demande DESC LIMIT 5')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <h1>Bonjour, <?= e($_SESSION['admin_prenom']) ?> 👋</h1>

        <div class="admin-stats">
            <div class="stat-card">
                <h2><?= $nb_projets ?></h2>
                <p>Projets publiés</p>
            </div>
            <div class="stat-card">
                <h2><?= $nb_messages ?></h2>
                <p>Messages non lus</p>
            </div>
            <div class="stat-card">
                <h2><?= $nb_demandes ?></h2>
                <p>Demandes non lues</p>
            </div>
        </div>

        <h2>5 dernières visites</h2>
        <table>
            <thead>
                <tr>
                    <th>IP</th>
                    <th>Page</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visites as $visite): ?>
                <tr>
                    <td><?= e($visite['adresse_ip']) ?></td>
                    <td><?= e($visite['page']) ?></td>
                    <td><?= e($visite['date_visite']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>5 dernières demandes</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dernieres_demandes as $demande): ?>
                <tr>
                    <td><?= e($demande['nom']) ?></td>
                    <td><?= e($demande['type_projet']) ?></td>
                    <td><?= e($demande['date_demande']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav>
            <a href="projets/liste.php">Gérer les projets</a> |
            <a href="utilisateurs/liste.php">Gérer les admins</a> |
            <a href="messages/liste.php">Messages</a> |
            <a href="demandes/liste.php">Demandes</a> |
            <a href="deconnexion.php">Se déconnecter</a>
        </nav>
    </div>
</body>
</html>