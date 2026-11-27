
<?php

$titreOnglet = 'Tableau de bord';
$afficherMenu = true;

ob_start();

?>

<div class="dashboard-container container py-5">


    <div class="mb-4">
        <p class="text-secondary small mb-1">TABLEAU DE BORD</p>

        <h1 class="fw-bold">Bonjour, Anderson </h1>

        <p class="text-secondary">
             vos demandes d'assistance...
        </p>
    </div>

    
    <div class="welcome-banner mb-4">

        <div>
            <span class="small">BESOIN D'ASSISTANCE ?</span>

            <h2 class="mt-2">Un problème informatique ?</h2>

            <p class="mb-3">
                Créez une demande et l'équipe d'Anderson&Junior vous répondra.
            </p>

            <a href="index.php?action=afficherPageNouveauTicket" class="btn btn-light">
                <i class="bi bi-plus-lg me-2"></i>
                Créer un ticket
            </a>
        </div>

        <i class="bi bi-headset banner-icon"></i>

    </div>

    <div class="row g-3 mb-5">

        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-folder2-open text-primary"></i>
                <h2>08</h2>
                <p>Tickets ouverts</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-clock-history text-warning"></i>
                <h2>03</h2>
                <p>Tickets en cours</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-check-circle text-success"></i>
                <h2>12</h2>
                <p>Tickets fermés</p>
            </div>
        </div>

    </div>


    <div class="tickets-section">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="fw-bold mb-1">Mes derniers tickets</h4>
                <p class="text-secondary small mb-0">
                    Consultez l'état de vos demandes.
                </p>
            </div>

            <a href="index.php?action=afficherPageMesTickets" class="text-primary text-decoration-none">
                Voir tout <i class="bi bi-arrow-right"></i>
            </a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Sujet</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>#TK-001</td>
                        <td>Problème de connexion</td>
                        <td>22 novembre 2026</td>
                        <td><span class="badge bg-warning-subtle text-warning-emphasis">En cours</span></td>
                    </tr>

                    <tr>
                        <td>#TK-002</td>
                        <td>Installation d'un logiciel</td>
                        <td>21 novembre 2026</td>
                        <td><span class="badge bg-success-subtle text-success-emphasis">Fermé</span></td>
                    </tr>

                    <tr>
                        <td>#TK-003</td>
                        <td>Imprimante non fonctionnelle</td>
                        <td>20 novembre 2026</td>
                        <td><span class="badge bg-primary-subtle text-primary-emphasis">Ouvert</span></td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

$contenu = ob_get_clean();

require 'vue/gabarit.php';

?>
