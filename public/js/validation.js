//validations inscription

document.addEventListener('DOMContentLoaded', function (){


const formulaireInscription = document.querySelector('.needs-validation');

/* Vérifier si le formulaire existe sur la page
    pour eviter d'afficher les erreurs dans d'autres pages*/
    if (formulaireInscription === null) {
        return;
    }

const motDePasse = document.getElementById('motDePasse');
const confirmation = document.getElementById('confirmationMotDePasse');

function verifierMotDePasse(){
    if(motDePasse.value !== confirmation.value){
        confirmation .setCustomValidity('les mot de passe ne sont pas identiques.');//pour le un msg d'erreur personalisé

    }
    else{
        confirmation .setCustomValidity('');
    }

   
}

 //pour que ca verifie pendant la saisie
    motDePasse.addEventListener('input', verifierMotDePasse);
    confirmation.addEventListener('input', verifierMotDePasse);

    //verifie quand on soumet le formulaire
formulaireInscription.addEventListener('submit', function(event) {

    verifierMotDePasse();

    if (!formulaireInscription.checkValidity()){
        event.preventDefault();
        event.stopPropagation();
        //check validity pour s'assurer que ca respect les contraintes html
    }

    formulaireInscription.classList.add('was-validated');//active les validation Bootstrap

    
});

});