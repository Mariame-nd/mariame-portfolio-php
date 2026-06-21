<?php
session_start();
require_once '../config/connexion.php';
require_once '../fonctions.php';

enregistrer_visite($pdo, 'resume.php');
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume | Mariame NDIAYE</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>

<body>

    <?php require '../composants/navigation.php'; ?>

    <section class="scroll-container">
        <h1 class="title-resume">Mon Parcours<span> et Ambition</span></h1>

        <div class="resume-main-content">
            <div class="resume-left">
                <section class="resume-section">
                    <h2 class="column-title"><i class='bx bx-user'></i> Identité et parcours</h2>
                    <div class="resume-content-box">
                        <p>Étudiante en deuxième année (L2) à l'ESTM, je suis une double formation en Génie logiciel &
                            Administration réseaux ainsi qu'en Mathématiques appliquées et Informatique.</p>
                    </div>
                </section>

                <section class="resume-section">
                    <h2 class="column-title"><i class='bx bx-code-alt'></i> Compétences techniques</h2>
                    <div class="resume-content-box">
                        <p>Développement full-stack (HTML, CSS, JavaScript, PHP, MySQL), administration réseaux (DHCP,
                            DNS), sécurité sous Linux et programmation de systèmes embarqués (Arduino, ESP32).</p>
                    </div>
                </section>

                <section class="resume-section">
                    <h2 class="column-title"><i class='bx bx-heart'></i> Expériences et Responsabilités</h2>
                    <div class="resume-content-box">
                        <p>Présidente de l'association "Al Qalb", je coordonne des actions de solidarité et des
                            campagnes de distribution alimentaire.</p>
                    </div>
                </section>

                <section class="resume-section ambition-box">
                    <h2 class="column-title"><i class='bx bxs-plane-take-off'></i> Mon Ambition</h2>
                    <div class="resume-content-box feature-box">
                        <p>Mon objectif est de devenir <strong>Ingénieure en Cybersécurité Aéronautique</strong>.</p>
                    </div>
                </section>
            </div>

            <div class="resume-right">
                <div class="profile-img-container">
                    <img src="../images/ia.png" alt="Mariame Ndiaye">
                </div>
            </div>
        </div>

        <div class="dna-footer">
            <div class="dna-item"><i class='bx bx-shield-quarter'></i><span>Aero-Cyber</span></div>
            <div class="dna-item"><i class='bx bx-chip'></i><span>Embedded Systems</span></div>
            <div class="dna-item"><i class='bx bx-line-chart'></i><span>Data Driven</span></div>
        </div>
    </section>
               <?php require '../composants/pied-de-page.php'; ?>
               <?php require '../composants/script.php'; ?>
</body>

</html>