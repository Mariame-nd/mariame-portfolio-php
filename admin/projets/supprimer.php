<?php
session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../fonctions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifier_token_csrf($_POST['csrf_token'] ?? '');

    $id = intval($_POST['id'] ?? 0);

    // Récupérer l'image pour la supprimer
    $stmt = $pdo->prepare('SELECT image FROM projets WHERE id = ?');
    $stmt->execute([$id]);
    $projet = $stmt->fetch();

    if ($projet) {
        // Supprimer l'image si elle existe
        if ($projet['image']) {
            $chemin = __DIR__ . '/../../images/projets/' . $projet['image'];
            if (file_exists($chemin)) {
                unlink($chemin);
            }
        }

        // Supprimer le projet
        $stmt = $pdo->prepare('DELETE FROM projets WHERE id = ?');
        $stmt->execute([$id]);
    }
}

header('Location: liste.php');
exit;