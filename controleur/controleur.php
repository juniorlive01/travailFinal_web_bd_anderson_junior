
<?php
 require_once 'modele/modeleTicket.php';

function afficherPageConnexion()
{
    require 'vue/connexion.php';
}

function afficherPageInscription()
{
    require 'vue/inscription.php';
}

function afficherPageAccueilEmploye(){
    require 'vue/accueilEmploye.php';
}


function afficherPageNouveauTicket()
{
    require 'vue/nouveauTicket.php';
}


function afficherPageMesTickets()
{
    require 'vue/mesTickets.php';
}

function afficherPagedetailTickets()
{
    require 'vue/detailTicket.php';
}

function afficherPageAccueilTechnicien()
{
    require 'vue/accueilTechnicien.php';
}

function afficherPageTousLesTickets()
{
    $tickets = ModeleTicket::obtenirTousLesTickets()->fetchAll();
    require 'vue/toutLesTickets.php';
}

function afficherPageDetailTicketTechnicien()
{
    require 'vue/detailTicketTechnicien.php';
}


function validationInscription(){
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
        strlen($motDePasse) < 8 || strlen($motDePasse) > 64 ||
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
        require 'vue/inscription.php';
        return;
    }

    //validation temporaire,a supprimer tantot!!!
    $msgSucces = 'Toutes les validations sont réussies ! Le formulaire est valide.';



// Plus tard, nous enregistrerons les données en base de données
require 'vue/inscription.php';

}


function validationConnexion(){

    $erreurs = [];

    $courriel = trim($_POST['courriel'] ?? '');
    $motDePasse = $_POST['motDePasse'] ?? '';

    //filter_var pour valider le format du
    if (!filter_var($courriel, FILTER_VALIDATE_EMAIL)) {
        $erreurs['courriel'] = 'Veuillez saisir une adresse courriel valide.';
    }

    if (empty($motDePasse)) {
        $erreurs['motDePasse'] = 'Veuillez saisir votre mot de passe.';
    }

    if (!empty($erreurs)) {
        require 'vue/connexion.php';
        return;
    }

    // La vérification des identifiants sera faite avec la base de données.
    $msgErreurConnexion = ' vérification php correct, verification des identifiants a faire';

    require 'vue/connexion.php';
}


?>
