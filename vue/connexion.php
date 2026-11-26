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


        <form method="post"
              action="index.php?action=connecter"
              class="needs-validation"
              novalidate>

            <div class="mb-3">

                <label for="courriel" class="form-label">
                    Adresse courriel
                </label>

                <input type="email"
                       class="form-control"
                       id="courriel"
                       name="courriel"
                       placeholder="nom@couriel.com"
                       required>

                <div class="invalid-feedback">
                    Veuillez entrer une adresse courriel valide.
                </div>

            </div>

            <div class="mb-4">

                <label for="motDePasse" class="form-label">
                    Mot de passe
                </label>

                <input type="password"
                       class="form-control"
                       id="motDePasse"
                       name="motDePasse"
                       placeholder="Votre mot de passe"
                       required>

                <div class="invalid-feedback">
                    Veuillez entrer votre mot de passe.
                </div>

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
