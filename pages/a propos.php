<?php
session_start();
require_once '../config/connexion.php';
require_once '../fonctions.php';

enregistrer_visite($pdo, 'a-propos.php');
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Mariame NDIAYE</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>

<body>

    <?php require '../composants/navigation.php'; ?>

    <section class="intro-section">
        <div class="photo-frame">
            <img src="../images/maphoto.jpeg" alt="Mariame Ndiaye">
        </div>

        <div class="intro-text">
            <h1 class="title-ask">À PROPOS <span class="cursive">de moi</span></h1>
            <div class="divider"></div>

            <p class="main-para">
                Je m’appelle <strong>Mariame Ndiaye</strong>, étudiante en Licence 2 en <strong>Génie Logiciel et
                    Administration Réseaux</strong>.
            </p>

            <p class="secondary-para">
                Passionnée par le numérique, je m'intéresse au développement web et à la sécurité des systèmes. Mon
                objectif est de devenir <strong>Ingénieure en Cybersécurité Aéronautique</strong>.
            </p>

            <div class="skills-wrapper">
                <h3 class="skills-subtitle"><i class='bx bxs-terminal'></i> Stack Technique</h3>
                <div class="skills-grid">
                    <div class="skill-item"><i class='bx bxl-html5'></i><span>HTML5</span></div>
                    <div class="skill-item"><i class='bx bxl-css3'></i><span>CSS3</span></div>
                    <div class="skill-item"><i class='bx bxl-javascript'></i><span>JS</span></div>
                    <div class="skill-item"><i class='bx bxl-php'></i><span>PHP</span></div>
                    <div class="skill-item"><i class='bx bxl-c-plus-plus'></i><span>C++</span></div>
                    <div class="skill-item"><i class='bx bxs-data'></i><span>SQL</span></div>
                    <div class="skill-item"><i class='bx bx-network-chart'></i><span>Réseaux</span></div>
                </div>
            </div>

            <div class="cv-button-container">
                <a href="contact.php" class="cv-link">ME CONTACTER</a>
            </div>
        </div>
    </section>

      <?php require '../composants/pied-de-page.php'; ?>
      <?php require '../composants/script.php'; ?>
</body>

</html>