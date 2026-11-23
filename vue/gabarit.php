
<?php

/** @var string $titreOnglet */
assert(isset($titreOnglet), 'La variable $titreOnglet doit être définie.');
assert(is_string($titreOnglet), 'Le titre doit être une chaîne de caractères.');

/** @var string $contenu */
assert(isset($contenu), 'La variable $contenu doit être définie.');
assert(is_string($contenu), 'Le contenu doit être une chaîne de caractères.');

$afficherMenu = $afficherMenu ?? false;

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">


    <link href="css/style.css" rel="stylesheet">

    <title><?= htmlspecialchars($titreOnglet, ENT_QUOTES, 'UTF-8') ?> | Support Desk</title>

</head>

<body class="min-vh-100 d-flex flex-column">

<!--pour afficher le menu en fonction du user(client ou TI)-->
<?php if ($afficherMenu): ?>
<header>
    <?php
    if (isset($espaceTechnicien) && $espaceTechnicien === true) {
        require_once 'travailFinal_web_bd_anderson_junior/vue/menuTechnicien.php';
    } else {
        require_once 'travailFinal_web_bd_anderson_junior/vue/menu.php';
    }
    ?>
</header>
<?php endif; ?>

    <main class="flex-fill">

        <?= $contenu ?>

    </main>

    <footer class="text-center py-3 border-top bg-white">

        <p class="mb-0 text-secondary">
            &copy; <?= date('Y') ?> Support Desk - Tous droits réservés
        </p>

    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


    <script src="js/bootstrap.js"></script>

</body>

</html>

