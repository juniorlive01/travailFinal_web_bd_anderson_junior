
<?php

session_start();

try{
    if(!isset($_GET['action'])){
        require 'vue/connexion.php';

        return;
    }

    switch($_GET['action']){
        case 'afficherPageConnexion':
            require 'vue/connexion.php';
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
