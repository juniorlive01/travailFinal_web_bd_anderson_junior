
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

        
        <!-- message de validation php temporaire, a supprimer(anderson)!!! -->
        <?php if (isset($msgSucces)) : ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($msgSucces, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

        <form method="post"
              action="index.php?action=inscrire"
              class="needs-validation"
              novalidate
              ><!-- Les champs sont transmis a post selon leurs attributs name -->

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>

                <input type="text" name="prenom" id="prenom"
                        class="form-control <?= isset($erreurs['prenom']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars($prenom ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        required minlength="2" maxlength="50">

<div class="invalid-feedback">
    <?= $erreurs['prenom'] ?? 'Veuillez saisir un prénom valide.' ?>
</div>
            </div>

            <div class="mb-3">
                 <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom"
                    class="form-control <?= isset($erreurs['nom']) ? 'is-invalid' : '' ?>"
                    value="<?= htmlspecialchars($nom ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required minlength="2" maxlength="50">

<div class="invalid-feedback">
    <?= $erreurs['nom'] ?? 'Veuillez saisir un nom valide.' ?>
</div>
            </div>

            <div class="mb-3">
                <label for="courriel" class="form-label">
                    Adresse courriel
                </label>

                <input type="email" name="courriel" id="courriel"
                    class="form-control <?= isset($erreurs['courriel']) ? 'is-invalid' : '' ?>"
                    value="<?= htmlspecialchars($courriel ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required maxlength="100">

<div class="invalid-feedback">
    <?= $erreurs['courriel'] ?? 'Veuillez saisir un courriel valide.' ?>
</div>
            </div>







<!--Verifications coté client sur le mott de passe avec :
   (?=.*[A-Z]) pour Au moins une lettre majuscule
   (?=.*[a-z])	Au moins une lettre minuscule
   (?=.*\d)	Au moins un chiffre
   (?=.*\W)	Au moins un caractère spécial
   .{8,}	Au moins 8 caractères au total-->
            <div class="mb-3">
                <label for="motDePasse" class="form-label">
                    Mot de passe
                </label>

                <input type="password" 
                name="motDePasse" 
                id="motDePasse"
                    class="form-control <?= isset($erreurs['motDePasse']) ? 'is-invalid' : '' ?>"
                    required minlength="8" maxlength="64"
                    pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*\W).{8,}">

<div class="invalid-feedback">
    <?= $erreurs['motDePasse'] ?? 'Le mot de passe ne respecte pas les critères requis.' ?>
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
                name="confirmationMotDePasse" 
                id="confirmationMotDePasse"
                class="form-control <?= isset($erreurs['confirmationMotDePasse']) ? 'is-invalid' : '' ?>"
                required minlength="8" maxlength="64">

<div class="invalid-feedback">
    <?= $erreurs['confirmationMotDePasse'] ?? 'Les mots de passe doivent être identiques.' ?>
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

require 'vue/gabarit.php';
?>
