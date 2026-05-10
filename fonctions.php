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