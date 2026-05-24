<?php
session_start();
require_once '../config/connexion.php';
require_once '../fonctions.php';

enregistrer_visite($pdo, 'contact.php');

$erreurs_contact = [];
$succes_contact  = false;
$nom      = '';
$email    = '';
$message  = '';

$succes_projet = false;
$recap_projet  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['btn_contact'])) {
        verifier_token_csrf($_POST['csrf_token'] ?? '');

        $nom     = nettoyer($_POST['nom']     ?? '');
        $email   = nettoyer($_POST['email']   ?? '');
        $message = nettoyer($_POST['message'] ?? '');

        if (!champ_requis($nom)) {
            $erreurs_contact[] = "Le nom est obligatoire.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs_contact[] = "L'adresse e-mail est invalide.";
        }
        if (!champ_requis($message)) {
            $erreurs_contact[] = "Le message ne peut pas être vide.";
        }

        if (empty($erreurs_contact)) {
            $stmt = $pdo->prepare('INSERT INTO messages_contact (nom, email, message) VALUES (?, ?, ?)');
            $stmt->execute([$nom, $email, $message]);
            $succes_contact = true;
            $nom = $email = $message = '';
        }
    }

    if (isset($_POST['btn_projet'])) {
        verifier_token_csrf($_POST['csrf_token'] ?? '');

        $recap_projet = [
            'service'     => nettoyer($_POST['service']     ?? ''),
            'budget'      => nettoyer($_POST['budget']      ?? ''),
            'description' => nettoyer($_POST['description'] ?? '')
        ];

        if (!empty($recap_projet['service']) && !empty($recap_projet['description'])) {
            $stmt = $pdo->prepare('INSERT INTO demandes_projet (nom, email, type_projet, description, budget) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([
                'Anonyme',
                'non renseigné',
                $recap_projet['service'],
                $recap_projet['description'],
                $recap_projet['budget']
            ]);
            $succes_projet = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Mariame NDIAYE</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <?php require '../composants/navigation.php'; ?>

    <div class="scroll-container">
        <h1 class="title-resume">Restons <span>en contact</span></h1>

        <div class="contact-grid">

            <section class="form-section">
                <h2 class="form-label"><i class='bx bx-envelope'></i> Me joindre</h2>

                <?php if ($succes_contact): ?>
                    <p style="background: rgba(0, 255, 0, 0.1); color: #00ff00; padding: 10px; border-radius: 5px; border: 1px solid #00ff00; margin-bottom: 15px;">
                        Merci ! Ton message a été envoyé avec succès.
                    </p>
                <?php endif; ?>

                <?php if (!empty($erreurs_contact)): ?>
                    <div style="background: rgba(255, 0, 0, 0.1); color: #ff4444; padding: 10px; border-radius: 5px; border: 1px solid #ff4444; margin-bottom: 15px;">
                        <?php foreach ($erreurs_contact as $erreur): ?>
                            <p style="margin: 0;">• <?= e($erreur) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form class="custom-form" method="POST" action="contact.php">
                    <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
                    <input type="text" name="nom" placeholder="Nom" value="<?= e($nom) ?>" required>
                    <input type="email" name="email" placeholder="Email" value="<?= e($email) ?>" required>
                    <textarea name="message" placeholder="Votre message..." rows="4" required><?= e($message) ?></textarea>
                    <button type="submit" name="btn_contact" class="btn-main">Envoyer</button>
                </form>

                <div class="contact-social-icons">
                    <a href="https://wa.me/221774920051" target="_blank" class="whatsapp"><i class='bx bxl-whatsapp'></i></a>
                    <a href="https://www.instagram.com/mariam__nde" target="_blank" class="instagram"><i class='bx bxl-instagram'></i></a>
                </div>
            </section>

            <section class="form-section">
                <h2 class="form-label"><i class='bx bx-edit'></i> Nouveau Projet</h2>

                <?php if ($succes_projet): ?>
                    <div style="background: rgba(0, 180, 255, 0.1); color: #00d4ff; padding: 10px; border-radius: 5px; border: 1px solid #00d4ff; margin-bottom: 15px;">
                        <strong>Demande envoyée avec succès !</strong><br>
                        Service : <?= e($recap_projet['service']) ?><br>
                        Budget : <?= e($recap_projet['budget']) ?> FCFA
                    </div>
                <?php endif; ?>

                <form class="custom-form" method="POST" action="contact.php">
                    <input type="hidden" name="csrf_token" value="<?= generer_token_csrf() ?>">
                    <select name="service" required>
                        <option value="" disabled selected>Type de service</option>
                        <option value="web">Web Design</option>
                        <option value="iot">IoT / ESP32</option>
                        <option value="cyber">Cybersécurité</option>
                    </select>
                    <input type="number" name="budget" placeholder="Budget estimé (FCFA)">
                    <textarea name="description" placeholder="Décrivez votre idée..." rows="4" required></textarea>
                    <button type="submit" name="btn_projet" class="btn-main">Soumettre</button>
                </form>
            </section>

        </div>
    </div>

    <?php require '../composants/pied-de-page.php'; ?>
    <?php require '../composants/script.php'; ?>
</body>
</html>