
<?php
$titreOnglet = 'Erreur';
$afficherMenu = false;

ob_start();
?>

<div class="auth-background d-flex justify-content-center align-items-center p-3">

    <div class="auth-card text-center">

        <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>

        <h2 class="mt-3">Une erreur est survenue</h2>

        <p class="text-secondary">
            <?= htmlspecialchars($msgErreur ?? 'Une erreur inattendue est survenue.', ENT_QUOTES, 'UTF-8') ?>
            	<!-- pour Empêcher l'injection de code  dans le message. -->
        </p>

        <a href="index.php?action=afficherPageConnexion"
           class="btn btn-primary mt-3">
            <i class="bi bi-house me-2"></i>
            Retour à l'accueil
        </a>

    </div>

</div>

<?php
$contenu = ob_get_clean();

require 'vue/gabarit.php';
?>
