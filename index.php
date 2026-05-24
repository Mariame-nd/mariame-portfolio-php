<?php
session_start();
require_once __DIR__ . '/config/connexion.php';
require_once __DIR__ . '/fonctions.php';

enregistrer_visite($pdo, 'index.php');
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mariame NDIAYE | Portfolio</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <?php require_once 'composants/navigation.php'; ?>

    <header class="hero">
        <span class="name-script">Mariame Ndiaye</span>
        <h1 class="hero-title">GÉNIE LOGICIEL ET<br>ADMINISTRATION RÉSEAUX</h1>
        <p class="hero-subtitle">Étudiante en informatique</p>
    </header>

    <section class="intro-section">
        <div class="photo-frame">
            <img src="images/hijab.jpeg" alt="Mariame Ndiaye">
        </div>

        <div class="intro-text">
            <h3 class="title-ask">SAVIEZ-VOUS <span class="cursive">que...</span></h3>
            <div class="divider"></div>

            <p class="main-para">
                Je m'intéresse au développement web ainsi qu'à la protection des données et à la cybersécurité.
            </p>

            <p class="secondary-para">
                Je conçois des interfaces modernes, responsives et adaptées aux besoins des utilisateurs pour garantir
                une expérience fluide et sécurisée.
            </p>

            <a href="./assets/CV Mariame NDIAYE.pdf" class="cv-link">TÉLÉCHARGER MON CV</a>
        </div>
    </section>

    <?php require 'composants/pied-de-page.php'; ?>
    <?php require 'composants/script.php'; ?>

</body>
</html>