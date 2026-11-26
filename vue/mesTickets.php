
<?php

$titreOnglet = 'Mes tickets';
$afficherMenu = true;

ob_start();

?>
  <!-- on vas doit remplacer tout les données fictives temporaire tels que le No de ticket en des objet dynamiques en JS-->

<div class="container py-5">


    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <p class="text-secondary small mb-1">ESPACE EMPLOYÉ / MES DEMANDES</p>

            <h1 class="fw-bold">Mes tickets</h1>

            <p class="text-secondary mb-0">
                 Suivez toutes vos demandes d'assistance ici.
            </p>
        </div>

        <a href="index.php?action=afficherPageNouveauTicket"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>
            Nouveau ticket
        </a>

    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="ticket-summary-card">
                <span>Total des tickets</span>
                <h3>23</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ticket-summary-card">
                <span>En attente ou en cours</span>
                <h3 class="text-warning">08</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ticket-summary-card">
                <span>Tickets fermés</span>
                <h3 class="text-success">15</h3>
            </div>
        </div>

    </div>

    <!-- Liste des tickets -->
       <!--                <h3>23</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ticket-summary-card">
                <span>En attente ou en cours</span>
                <h3 class="text-warning">08</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ticket-summary-card">
                <span>Tickets fermés</span>
                <h3 class="text-success">15</h3>
            </div>
        </div>-->
    <div class="my-tickets-card">

       
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>
                <h4 class="fw-bold mb-1">Toutes mes demandes</h4>
                <!--<p class="text-secondary small mb-0">
                    Consultez l'historique de vos tickets.
                </p>-->
            </div>

            <div class="d-flex flex-wrap gap-2">

                <div class="input-group ticket-search">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text"
                           class="form-control"
                           placeholder="Rechercher...">
                </div>

                <select class="form-select ticket-filter">
                    <option value="">Tous les statuts</option>
                    <option value="ouvert">Ouvert</option>
                    <option value="encours">En cours</option>
                    <option value="ferme">Fermé</option>
                </select>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Sujet</th>
                        <th>Catégorie</th>
                        <th>Date de création</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td class="fw-semibold">#TK-001</td>
                        <td>Problème de connexion</td>
                        <td>Réseau</td>
                        <td>22 nov. 2026</td>
                        <td>
                            <span class="priority-high">Élevée</span>
                        </td>
                        <td>
                            <span class="badge bg-warning-subtle text-warning-emphasis">
                                En cours
                            </span>
                        </td>
                        <td>
                            <a href="#" class="ticket-action">
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">#TK-002</td>
                        <td>Installation d'un logiciel</td>
                        <td>Logiciel</td>
                        <td>21 nov. 2026</td>
                        <td>
                            <span class="priority-normal">Normale</span>
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success-emphasis">
                                Fermé
                            </span>
                        </td>
                        <td>
                            <a href="#" class="ticket-action">
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">#TK-003</td>
                        <td>Imprimante non fonctionnelle</td>
                        <td>Matériel</td>
                        <td>20 nov. 2026</td>
                        <td>
                            <span class="priority-urgent">Urgente</span>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary-emphasis">
                                Ouvert
                            </span>
                        </td>
                        <td>
                            <a href="#" class="ticket-action">
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">#TK-004</td>
                        <td>Problème de mot de passe</td>
                        <td>Compte</td>
                        <td>18 nov. 2026</td>
                        <td>
                            <span class="priority-low">Faible</span>
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success-emphasis">
                                Fermé
                            </span>
                        </td>
                        <td>
                            <a href="#" class="ticket-action">
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!-- Pagination visuelle -->
        <div class="d-flex justify-content-between align-items-center mt-3">

            <small class="text-secondary">
                Affichage de 1 à 4 sur 23 tickets
            </small>

            <div class="btn-group">

                <button class="btn btn-light border" disabled>
                    <i class="bi bi-chevron-left"></i>
                </button>

                <button class="btn btn-primary">1</button>

                <button class="btn btn-light border">2</button>

                <button class="btn btn-light border">3</button>

                <button class="btn btn-light border">
                    <i class="bi bi-chevron-right"></i>
                </button>

            </div>

        </div>

    </div>

</div>

<?php

$contenu = ob_get_clean();

require 'vue/gabarit.php';

?>
