
<?php

function afficherPageConnexion()
{
    require 'travailFinal_web_bd_anderson_junior/vue/connexion.php';
}

function afficherPageInscription()
{
    require 'travailFinal_web_bd_anderson_junior/vue/inscription.php';
}

function afficherPageAccueilEmploye(){
    require 'travailFinal_web_bd_anderson_junior/vue/accueilEmploye.php';
}


function afficherPageNouveauTicket()
{
    require 'travailFinal_web_bd_anderson_junior/vue/nouveauTicket.php';
}


function afficherPageMesTickets()
{
    require 'travailFinal_web_bd_anderson_junior/vue/mesTickets.php';
}

function afficherPagedetailTickets()
{
    require 'travailFinal_web_bd_anderson_junior/vue/detailTicket.php';
}

function afficherPageAccueilTechnicien()
{
    require 'travailFinal_web_bd_anderson_junior/vue/accueilTechnicien.php';
}

function afficherPageTousLesTickets()
{
    require 'travailFinal_web_bd_anderson_junior/vue/toutLesTickets.php';
}

function afficherPageDetailTicketTechnicien()
{
    require 'travailFinal_web_bd_anderson_junior/vue/detailTicketTechnicien.php';
}


function inscrire(){
    $erreurs = [];

    $prenom = trim($_POST['prenom'] ?? '');//recupere les variables du post si absent recupere un vide
    $nom = trim($_POST['nom'] ?? '');
    $courriel = trim($_POST['courriel'] ?? '');
    $motDePasse = $_POST['motDePasse'] ?? '';
    $confirmation = $_POST['confirmationMotDePasse'] ?? '';

    if(strlen($prenom) < 2 || strlen($prenom) > 50){
        $erreurs['prenom'] = 'le prénom doit contenir entre 2 et 50 carateres.';
    }

    if (strlen($nom) < 2 || strlen($nom) > 50) {
        $erreurs['nom'] = 'Le nom doit contenir entre 2 et 50 caractères.';
    }

    if (!filter_var($courriel, FILTER_VALIDATE_EMAIL) || strlen($courriel) > 100) {
        $erreurs['courriel'] = 'Veuillez saisir une adresse courriel valide.';
    }

    if (
        strlen($motDePasse) < 8 ||
        strlen($motDePasse) > 64 ||
        !preg_match('/[A-Z]/', $motDePasse) ||
        !preg_match('/[a-z]/', $motDePasse) ||
        !preg_match('/[0-9]/', $motDePasse) ||
        !preg_match('/[^a-zA-Z0-9]/', $motDePasse)
    ) {
        $erreurs['motDePasse'] = 'Le mot de passe ne respecte pas les critères de sécurité.';
    }

    if ($motDePasse !== $confirmation) {
        $erreurs['confirmationMotDePasse'] = 'Les mots de passe ne sont pas identiques.';
    }

    if (!empty($erreurs)) {
        require 'travailFinal_web_bd_anderson_junior/vue/inscription.php';
        return;
    }

    // plus tard on doit enregistrer  en base de données 
    echo 'Les validations PHP sont réussies ';

}


?>
