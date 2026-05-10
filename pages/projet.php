<?php
require_once '../fonctions.php';

// 1. Tableau de données contenant tes projets (Section 5.3 du cours)
$projets = [
    [
        'id'    => 'portfolio',
        'titre' => 'Mon Portfolio',
        'desc'  => 'Développement Web & Design',
        'img'   => '../images/portfolio.png',
        'lien'  => 'https://mariame-nd.github.io/mariame.portfolio/',
        'type'  => 'externe'
    ],
    [
        'id'    => 'alqalb',
        'titre' => 'Al Qalb',
        'desc'  => 'Site de Solidarité Communautaire',
        'img'   => '../images/al qalb.png',
        'lien'  => 'https://mariame-nd.github.io/projet-web-alqalb/',
        'type'  => 'externe'
    ],
    [
        'id'    => 'resto',
        'titre' => 'Spicy Food',
        'desc'  => 'Interface Restaurant Teranga',
        'img'   => '../images/restaurant.png',
        'lien'  => '#modal-resto',
        'type'  => 'modal'
    ],
    [
        'id'    => 'shop',
        'titre' => 'E-Commerce',
        'desc'  => 'Boutique de Maillots de Foot',
        'img'   => '../images/e commerce.png',
        'lien'  => '#modal-shop',
        'type'  => 'modal'
    ],
    [
        'id'    => 'flyers',
        'titre' => 'Samb Sa Alal',
        'desc'  => 'Business Model Canvas - Groupe 4',
        'img'   => '../images/flyers.png',
        'lien'  => '../assets/Business Model Groupe 4.pdf',
        'type'  => 'pdf'
    ],
    [
        'id'    => 'esp',
        'titre' => 'ESP32 Server',
        'desc'  => 'Arduino & Domotique IoT',
        'img'   => '../images/esp32.png',
        'lien'  => '#modal-esp',
        'type'  => 'modal'
    ]
];

// 2. Récupération du mot-clé via GET (Section 5.3)
$mot_cle = nettoyer($_GET['q'] ?? '');
$resultats = [];

if ($mot_cle !== '') {
    foreach ($projets as $projet) {
        if (stripos($projet['titre'], $mot_cle) !== false || stripos($projet['desc'], $mot_cle) !== false) {
            $resultats[] = $projet;
        }
    }
} else {
    $resultats = $projets;
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets | Mariame NDIAYE</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

    <?php require '../composants/navigation.php'; ?>

    <header class="hero" style="padding-bottom: 20px;">
        <span class="name-script">Mes Réalisations</span>
        <h1 class="hero-title">ESPACE INTERACTIF</h1>
    </header>

    <section class="search-section">
        <div class="search-container">
            <h2 class="skills-subtitle"><i class='bx bx-search-alt'></i> Rechercher un projet</h2>
            <div class="search-box">
                <form method="GET" action="projet.php" style="display: flex; width: 100%; gap: 10px;">
                    <input type="text" name="q" id="searchInput" placeholder="Ex: ESP32, Portfolio, E-commerce..." value="<?= htmlspecialchars($mot_cle) ?>">
                    <button type="submit" id="searchBtn" class="cv-link" style="padding: 10px 25px; border: none; cursor: pointer;">Filtrer</button>
                </form>
            </div>
        </div>
    </section>

    <section class="projects-section">
        <div class="projects-grid" id="projectsGrid">

            <?php if (empty($resultats)) : ?>
                <p style="grid-column: 1/-1; text-align: center;">Aucun projet trouvé pour "<?= htmlspecialchars($mot_cle) ?>".</p>
            <?php else : ?>
                <?php foreach ($resultats as $p) : ?>
                    <div class="project-card">
                        <img src="<?= htmlspecialchars($p['img']) ?>" alt="<?= htmlspecialchars($p['titre']) ?>">
                        <div class="project-overlay">
                            <h4><?= htmlspecialchars($p['titre']) ?></h4>
                            <p><?= htmlspecialchars($p['desc']) ?></p>
                            <a href="<?= $p['lien'] ?>" 
                               <?= ($p['type'] === 'externe' || $p['type'] === 'pdf') ? 'target="_blank"' : '' ?> 
                               class="view-btn">
                               <?= ($p['type'] === 'modal') ? 'Détails' : (($p['type'] === 'pdf') ? 'Voir PDF' : 'Voir le site') ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </section>

    <div id="modal-resto" class="modal-overlay">
        <div class="modal-card">
            <a href="#" class="modal-close">&times;</a>
            <img src="../images/restaurant.png" alt="Restaurant Details">
            <div class="modal-body">
                <h3>Concept : Teranga Food</h3>
                <p>Développement d'une interface responsive pour la gestion des commandes et la présentation des menus.</p>
            </div>
        </div>
    </div>

    <div id="modal-shop" class="modal-overlay">
        <div class="modal-card">
            <a href="#" class="modal-close">&times;</a>
            <img src="../images/e commerce.png" alt="Shop Details">
            <div class="modal-body">
                <h3>Vente de Maillots</h3>
                <p>Plateforme spécialisée avec système de filtrage et catalogue dynamique.</p>
            </div>
        </div>
    </div>

    <div id="modal-esp" class="modal-overlay">
        <div class="modal-card">
            <a href="#" class="modal-close">&times;</a>
            <img src="../images/esp32.png" alt="ESP32 Details">
            <div class="modal-body">
                <h3>IoT & Domotique</h3>
                <p>Serveur web hébergé sur ESP32 pour le contrôle de capteurs en temps réel.</p>
            </div>
        </div>
    </div>

    <?php require '../composants/pied-de-page.php'; ?>
    <?php require '../composants/script.php'; ?>
</body>
</html>