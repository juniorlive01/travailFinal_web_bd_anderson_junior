
<?php
$titreOnglet = 'Inscription';
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
            <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
            <h2 class="mt-2">Créer un compte</h2>
            <p class="text-secondary">
                Rejoignez notre plateforme de support
            </p>
        </div>

        <form method="post"
              action="index.php?action=inscrire"
              class="needs-validation"
              novalidate>

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>

                <input type="text"
                       class="form-control"
                       id="prenom"
                       name="prenom"
                       placeholder="Votre prénom"
                       required>

                <div class="invalid-feedback">
                    Veuillez entrer votre prénom.
                </div>
            </div>

            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>

                <input type="text"
                       class="form-control"
                       id="nom"
                       name="nom"
                       placeholder="Votre nom"
                       required>

                <div class="invalid-feedback">
                    Veuillez entrer votre nom.
                </div>
            </div>

            <div class="mb-3">
                <label for="courriel" class="form-label">
                    Adresse courriel
                </label>

                <input type="email"
                       class="form-control"
                       id="courriel"
                       name="courriel"
                       placeholder="nom@entreprise.com"
                       required>

                <div class="invalid-feedback">
                    Veuillez entrer une adresse courriel valide.
                </div>
            </div>

            <div class="mb-3">
                <label for="motDePasse" class="form-label">
                    Mot de passe
                </label>

                <input type="password"
                       class="form-control"
                       id="motDePasse"
                       name="motDePasse"
                       placeholder="Créer un mot de passe"
                       pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*\W).{8,}"
                       required>

                <div class="invalid-feedback">
                    Le mot de passe doit respecter les critères de sécurité.
                </div>

                <div class="form-text">
                    8 caractères minimum, une majuscule, une minuscule,
                    un chiffre et un caractère spécial.
                </div>
            </div>

            <div class="mb-4">
                <label for="confirmationMotDePasse" class="form-label">
                    Confirmer le mot de passe
                </label>

                <input type="password"
                       class="form-control"
                       id="confirmationMotDePasse"
                       name="confirmationMotDePasse"
                       placeholder="Confirmer le mot de passe"
                       required>

                <div class="invalid-feedback">
                    Les deux mots de passe doivent être identiques.
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2" id="btn-creer-compte">
                <i class="bi bi-person-check me-2"></i>
                Créer mon compte
            </button>

        </form>

        <div class="text-center mt-4">
            <span class="text-secondary">
                Vous avez déjà un compte ?
            </span>

            <a href="index.php?action=afficherPageConnexion"
               class="text-primary text-decoration-none fw-semibold">
                Se connecter
            </a>
        </div>

    </div>

</div>

<?php
$contenu = ob_get_clean();
require 'travailFinal_web_bd_anderson_junior/vue/gabarit.php';
?>
