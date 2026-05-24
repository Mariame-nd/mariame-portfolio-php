<?php

/**
 * Nettoie une valeur pour l'afficher sans risque dans du HTML.
 * @param string $valeur  La valeur brute
 * @return string         La valeur nettoyée
 */
function nettoyer(string $valeur): string {
    // Supprime les espaces inutiles et neutralise les balises HTML [cite: 63, 64]
    return htmlspecialchars(trim($valeur));
}

/**
 * Vérifie qu'un champ n'est pas vide après nettoyage.
 * @param string $valeur  La valeur à vérifier
 * @return bool           true si le champ est valide, false sinon
 */
function champ_requis(string $valeur): bool {
    // Vérifie si le champ contient du texte réel [cite: 63]
    return !empty(trim($valeur));
}




// base de donnees 
function enregistrer_visite($pdo, $page) {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    $stmt = $pdo->prepare('INSERT INTO visites (adresse_ip, page) VALUES (?, ?)');
    $stmt->execute([$ip, $page]);
}

function generer_token_csrf() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifier_token_csrf($token) {
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die('Token CSRF invalide.');
    }
}

function e($valeur) {
    return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8');
}