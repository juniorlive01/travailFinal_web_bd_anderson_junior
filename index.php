<?php
session_start();

require 'controleur/controleur.php';

try{
    if(!isset($_GET['action'])){

        afficherPageConnexion();

        return;
    }

    switch($_GET['action']){
        case 'afficherPageConnexion':
            afficherPageConnexion();
            break;

        case 'afficherPageInscription':
            afficherPageInscription();
            break;
        
        case 'inscrire':
            validationInscription();
            break;

        case 'connecter':
            validationConnexion();
            break;

        case 'afficherPageAccueilEmploye':
            afficherPageAccueilEmploye();
            break;

        
        case 'afficherPageNouveauTicket':
            afficherPageNouveauTicket();
            break;


        case 'afficherPageMesTickets':
            afficherPageMesTickets();
            break;

        case 'afficherPageDetailTickets':
            afficherPageDetailTickets();
            break;

        case 'afficherPageAccueilTechnicien':
            afficherPageAccueilTechnicien();
            break;

        case 'afficherPageTousLesTickets':
            afficherPageTousLesTickets();
            break;

        case 'afficherPageDetailTicketTechnicien':
            afficherPageDetailTicketTechnicien();
            break;



        default:
            throw new Exception('404 : Action non supportée');

    }
}
catch(Exception $ex){

$msgErreur = $ex->getMessage();

require 'vue/erreur.php';
}

?>
