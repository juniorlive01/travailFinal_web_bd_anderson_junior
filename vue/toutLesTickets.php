
<?php

$titreOnglet = 'Tous les tickets';
$afficherMenu = true;
$espaceTechnicien = true;

ob_start();
?>

<div class="container py-5">


    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <span class="text-primary fw-semibold small">GESTION DU SUPPORT</span>
            <h2 class="fw-bold mt-2 mb-1">Tous les tickets</h2>
            <p class="text-secondary mb-0">
                Consultez et gérez les demandes des employés.
            </p>
        </div>

        <span class="badge text-bg-primary px-3 py-2">
            25 tickets au total
        </span>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="ticket-summary-card">
                <span>Tickets ouverts</span>
                <h3>12</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ticket-summary-card">
                <span>Tickets en cours</span>
                <h3>08</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ticket-summary-card">
                <span>Tickets fermés</span>
                <h3>05</h3>
            </div>
        </div>

    </div>


    <div class="my-tickets-card">

        <div class="mb-4">
            <h5 class="fw-bold mb-1">Liste des demandes</h5>
            <p class="text-secondary small mb-0">
                Recherchez et filtrez les tickets selon vos besoins.
            </p>
        </div>


        <div class="d-flex flex-wrap gap-2 mb-4">

            <div class="input-group ticket-search flex-grow-1">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search text-secondary"></i>
                </span>
                <input type="search" class="form-control"
                       placeholder="Rechercher un ticket...">
            </div>

            <select class="form-select ticket-filter">
                <option value="">Tous les statuts</option>
                <option>Ouvert</option>
                <option>En cours</option>
                <option>Fermé</option>
            </select>

            <select class="form-select ticket-filter">
                <option value="">Toutes les priorités</option>
                <option>Urgente</option>
                <option>Élevée</option>
                <option>Normale</option>
                <option>Faible</option>
            </select>

            <select class="form-select ticket-filter">
                <option value="">Toutes les catégories</option>
                <option>Matériel</option>
                <option>Logiciel</option>
                <option>Réseau</option>
                <option>Compte</option>
                <option>Autre</option>
            </select>

        </div>


        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Employé</th>
                        <th>Sujet</th>
                        <th>Catégorie</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Créé le</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td class="fw-semibold">#TK-024</td>
                        <td>Anderson</td>
                        <td>Problème Wi-Fi</td>
                        <td>Réseau</td>
                        <td><span class="priority-urgent">Urgente</span></td>
                        <td><span class="badge text-bg-warning">En cours</span></td>
                        <td>22 nov. 2026</td>
                        <td>
                            <a  href="index.php?action=afficherPageDetailTicketTechnicien" class="ticket-action">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                    <?php foreach ($tickets as $ticket): ?>
                        <?php
                        $styleEtape = [
                            'ouvert'  => ['text-bg-primary', 'Ouvert'],
                            'encours' => ['text-bg-warning', 'En cours'],
                            'ferme'   => ['text-bg-success', 'Fermé'],
                        ];
                        [$classeEtape, $texteEtape] = $styleEtape[$ticket['etape']];

                        $stylePriorite = [
                            'Urgente' => 'priority-urgent',
                            'Élevée'  => 'priority-high',
                            'Normale' => 'priority-normal',
                            'Faible'  => 'priority-low',
                        ];
                        $classePriorite = $stylePriorite[$ticket['priorite']] ?? 'priority-normal';
                        ?>
    <tr>
        <td class="fw-semibold">#<?= (int) $ticket['id_ticket'] ?></td>
        <td><?= htmlspecialchars($ticket['first_name'] . ' ' . $ticket['last_name']) ?></td>
        <td><?= htmlspecialchars($ticket['title']) ?></td>
        <td><?= htmlspecialchars($ticket['category_name']) ?></td>
        <td><?= htmlspecialchars($ticket['priorite']) ?></td>
        <td> ...le badge, à l'étape 4... </td>
        <td><?= date('d/m/Y', strtotime($ticket['creation_date'])) ?></td>
        <td> ...le bouton « Voir », à l'étape 5... </td>
    </tr>
<?php endforeach; ?>

                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
            <small class="text-secondary">
                Affichage de 5 tickets sur 25
            </small>

            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Précédent</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>

<?php
$contenu = ob_get_clean();

require 'vue/gabarit.php';
?>
