<?php
$page_courante = basename($_SERVER['PHP_SELF']);
$dans_pages    = strpos($_SERVER['PHP_SELF'], '/pages/') !== false;
$racine        = $dans_pages ? '../' : '';
?>

<nav class="navbar">
    <div class="nav-container">
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <a href="<?= $racine ?>index.php" class="nav-logo">Mariame</a>
        <ul class="nav-list" id="nav-list">
            <li><a href="<?= $racine ?>index.php"              <?php if ($page_courante === 'index.php')    echo 'class="active"'; ?>>Accueil</a></li>
            <li><a href="<?= $racine ?>pages/a propos.php"     <?php if ($page_courante === 'a propos.php') echo 'class="active"'; ?>>À Propos</a></li>
            <li><a href="<?= $racine ?>pages/projet.php"       <?php if ($page_courante === 'projet.php')   echo 'class="active"'; ?>>Projets</a></li>
            <li><a href="<?= $racine ?>pages/resume.php"       <?php if ($page_courante === 'resume.php')   echo 'class="active"'; ?>>Résumé</a></li>
            <li><a href="<?= $racine ?>pages/contact.php"      <?php if ($page_courante === 'contact.php')  echo 'class="active"'; ?>>Contact</a></li>
        </ul>
        <button id="theme-toggle" class="theme-switch">
            <i class='bx bx-moon'></i>
        </button>
    </div>
</nav>