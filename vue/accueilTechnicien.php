
<?php

$titreOnglet = 'Espace technicien';
$afficherMenu = true;
$espaceTechnicien = true;

ob_start();
?>

<div class="container dashboard-container py-5">


    <div class="mb-4">
        <span class="text-primary fw-semibold small">ESPACE TECHNICIEN</span>
        <h2 class="fw-bold mt-2 mb-1">Bonjour, Zaparo le Technicien !</h2>

        <!-- <p class="text-secondary mb-0">
            Voici un aperçu de l'activité du support informatique.
        </p> -->
    </div>


    <div class="welcome-banner mb-4">
        <div class="row align-items-center">
            <div class="col-md-8 position-relative">
                <span>GESTION DU SUPPORT TI</span>
                <h2 class="mt-3 mb-2">Gardez le contrôle des demandes.</h2>
                <p class="mb-4">
                    Veillez suivre la progression des tickets qui vous sont alloués
    
                </p>
                <a href="index.php?action=afficherPageTousLesTickets"
                   class="btn btn-light text-primary fw-semibold px-4">
                    Consulter les tickets
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                <i class="bi bi-headset banner-icon"></i>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-inbox text-primary"></i>
                <h2>12</h2>
                <p>Tickets ouverts</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-arrow-repeat text-warning"></i>
                <h2>08</h2>
                <p>Tickets en cours</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-check-circle text-success"></i>
                <h2>35</h2>
                <p>Tickets fermés</p>
            </div>
        </div>

    </div>


    <div class="tickets-section">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h5 class="fw-bold mb-1">Dernières demandes</h5>
                <p class="text-secondary small mb-0">
                    Les demandes récemment soumises par les employés.
                </p>
            </div>

            <a href="index.php?action=afficherPageTousLesTickets"
               class="btn btn-outline-primary btn-sm px-3">
                Voir tous les tickets
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Employé</th>
                        <th>Sujet</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="fw-semibold">#TK-024</td>
                        <td>Anderson</td>
                        <td>Problème de connexion Wi-Fi</td>
                        <td><span class="priority-urgent">Urgente</span></td>
                        <td><span class="badge text-bg-warning">En cours</span></td>
                        <td>
                            <a href="#" class="ticket-action">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">#TK-023</td>
                        <td>Marie Dupont</td>
                        <td>Imprimante non détectée</td>
                        <td><span class="priority-normal">Normale</span></td>
                        <td><span class="badge text-bg-primary">Ouvert</span></td>
                        <td>
                            <a href="#" class="ticket-action">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">#TK-022</td>
                        <td>Jean Martin</td>
                        <td>Installation de logiciel</td>
                        <td><span class="priority-low">Faible</span></td>
                        <td><span class="badge text-bg-success">Fermé</span></td>
                        <td>
                            <a href="#" class="ticket-action">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>

<?php
$contenu = ob_get_clean();

require 'travailFinal_web_bd_anderson_junior/vue/gabarit.php';
?>
