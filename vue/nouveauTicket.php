
<?php

$titreOnglet = 'Nouveau ticket';
$afficherMenu = true;

ob_start();

?>

<div class="container py-5">

    <div class="mb-4">

        <p class="text-secondary small mb-1">MES DEMANDES / NOUVEAU TICKET</p>

        <h1 class="fw-bold">Créer un ticket</h1>

        <p class="text-secondary">
            Décrivez votre problème afin que notre équipe puisse vous aider.
        </p>

    </div>

    <div class="row g-4">


        <div class="col-lg-8">

            <div class="ticket-form-card">

                <form method="post"
                      action="#"
                      enctype="multipart/form-data">

                  
                    <div class="mb-4">

                        <label for="sujet" class="form-label fw-semibold">
                            Sujet du problème
                        </label>

                        <input type="text"
                               class="form-control"
                               id="sujet"
                               name="sujet"
                               placeholder="Ex. : Impossible de se connecter au réseau"
                               required>

                    </div>

                    
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">

                            <label for="categorie" class="form-label fw-semibold">
                                Catégorie
                            </label>

                            <select class="form-select"
                                    id="categorie"
                                    name="categorie"
                                    required>

                                <option value="">Choisir une catégorie</option>
                                <option value="materiel">Matériel</option>
                                <option value="logiciel">Logiciel</option>
                                <option value="reseau">Réseau</option>
                                <option value="compte">Compte utilisateur</option>
                                <option value="autre">Autre</option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label for="priorite" class="form-label fw-semibold">
                                Priorité
                            </label>

                            <select class="form-select"
                                    id="priorite"
                                    name="priorite"
                                    required>

                                <option value="">Choisir une priorité</option>
                                <option value="faible">Faible</option>
                                <option value="normale">Normale</option>
                                <option value="elevee">Élevée</option>
                                <option value="urgente">Urgente</option>

                            </select>

                        </div>

                    </div>


                    <div class="mb-4">

                        <label for="description" class="form-label fw-semibold">
                            Description du problème
                        </label>

                        <textarea class="form-control"
                                  id="description"
                                  name="description"
                                  rows="6"
                                  placeholder="Expliquez précisément le problème rencontré..."
                                  required></textarea>

                        <div class="form-text">
                            Donnez autant de détails que possible pour faciliter le diagnostic.
                        </div>

                    </div>

                    <!-- pour televerser un Pièce jointe -->
                    <div class="mb-4">

                        <label for="pieceJointe" class="form-label fw-semibold">
                            Pièce jointe <span class="text-secondary fw-normal">(facultatif)</span>
                        </label>

                        <input type="file"
                               class="form-control"
                               id="pieceJointe"
                               name="pieceJointe"
                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">

                        <div class="form-text">
                            Formats acceptés : JPG, PNG, PDF et DOCX.
                        </div>

                    </div>

                    <hr class="my-4">

               
                    <div class="d-flex justify-content-end gap-2">

                        <a href="index.php?action=afficherPageAccueilEmploye"
                           class="btn btn-light border">
                            Annuler
                        </a>

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>
                            Envoyer la demande
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- Informations complémentaires 
        <div class="col-lg-4">

            <div class="ticket-info-card">

                <div class="info-icon mb-3">
                    <i class="bi bi-lightbulb"></i>
                </div>

                <h5 class="fw-bold">Quelques conseils</h5>

                <p class="text-secondary small">
                    Pour obtenir une assistance plus rapide :
                </p>

                <ul class="text-secondary small ps-3">

                    <li class="mb-3">
                        Choisissez la catégorie correspondant à votre problème.
                    </li>

                    <li class="mb-3">
                        Décrivez les étapes qui ont provoqué le problème.
                    </li>

                    <li class="mb-3">
                        Ajoutez une capture d'écran si elle peut aider.
                    </li>

                    <li>
                        Choisissez une priorité adaptée à la situation.
                    </li>

                </ul>

            </div>

        </div>
        -->

    </div>

</div>

<?php

$contenu = ob_get_clean();

require 'vue/gabarit.php';

?>
