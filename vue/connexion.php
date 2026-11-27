<?php

$titreOnglet = 'connexion';
$afficherMenu = false;



ob_start();
?>


<div class="auth-header">

    <div class="container d-flex align-items-center gap-2">

        <i class="bi bi-headset fs-2"></i>

        <div>
            <h4 class="mb-0">SUPPORT TI ANDERSON&JUNIOR</h4>
            <small>Votre assistance informatique</small>
        </div>

    </div>

</div>


<div class="auth-background d-flex justify-content-center align-items-center p-3">

    <div class="auth-card">

        <div class="text-center mb-4">

            <i class="bi bi-person-circle fs-1 text-primary"></i>

            <h2 class="mt-2">Bienvenue chez Anderson&Junior </h2>

            <p class="text-secondary">
                Connectez-vous pour accéder à votre espace.
            </p>

        </div>

        <?php if (isset($msgErreurConnexion)) : ?>
            <div class="alert alert-warning">
                <?= htmlspecialchars($msgErreurConnexion, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; //message pour confirmer les validations php du courriel et mot de passe mais pas encore implementé dans bd?>

        <form method="post"
              action="index.php?action=connecter"
              class="needs-validation"
              novalidate>

            <div class="mb-3">

                <label for="courriel" class="form-label">
                    Adresse courriel
                </label>

                <input type="email"
                    class="form-control <?= isset($erreurs['courriel']) ? 'is-invalid' : '' ?>"
                    id="courriel"
                    name="courriel"
                    placeholder="nom@couriel.com"
                    value="<?= htmlspecialchars($courriel ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required>

                <div class="invalid-feedback">
                    <?= $erreurs['courriel'] ?? 'Veuillez entrer une adresse courriel valide.' ?>
                </div>

            </div>

           <div class="mb-4">

                <label for="motDePasse" class="form-label">
                    Mot de passe
                </label>

                <input type="password"
                    class="form-control <?= isset($erreurs['motDePasse']) ? 'is-invalid' : '' ?>"
                    id="motDePasse"
                    name="motDePasse"
                    placeholder="Votre mot de passe"
                    required>

                <div class="invalid-feedback">
                    <?= $erreurs['motDePasse'] ?? 'Veuillez entrer votre mot de passe.' ?>
                </div>
                <!-- verifie uniquement si cest present et pas si cest valide -->

            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">

                <i class="bi bi-box-arrow-in-right me-2"></i>

                Se connecter

            </button>

        </form>

        <!-- Pour s'inscrire-->
        <div class="text-center mt-4">

            <span class="text-secondary">
                Vous n'avez pas encore de compte ?
            </span>

            <a href="index.php?action=afficherPageInscription"
               class="text-primary text-decoration-none fw-semibold">

                Créer un compte

            </a>

        </div>

    </div>

</div>

<?php

$contenu = ob_get_clean();

require 'vue/gabarit.php';

?>
