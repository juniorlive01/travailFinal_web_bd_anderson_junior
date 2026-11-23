
<?php

$titreOnglet = 'Gestion du ticket';
$afficherMenu = true;
$espaceTechnicien = true;

ob_start();
?>

<div class="container py-5">


    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <a href="index.php?action=afficherPageTousLesTickets"
               class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-left me-2"></i>Retour aux tickets
            </a>

            <h2 class="fw-bold mt-3 mb-1">Problème de connexion Wi-Fi</h2>
            <p class="text-secondary mb-0">
                Ticket #TK-024 · Soumis par Anderson
            </p>
        </div>

        <span class="badge rounded-pill text-bg-warning px-3 py-2">
            En cours
        </span>
    </div>

    <div class="row g-4">

        <!-- Conversation publique -->
        <div class="col-lg-8">

            <div class="ticket-conversation mb-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Conversation avec le client</h5>
                    <span class="text-secondary small">2 messages</span>
                </div>

                <div class="message-item mb-4">
                    <div class="d-flex gap-3">
                        <div class="message-avatar employee-avatar">A</div>

                        <div class="flex-fill">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <strong>Ngoulboutara</strong>
                                <small class="text-secondary">22 nov. 2026 · 09:30</small>
                            </div>

                            <div class="message-bubble mt-2">
                                Bonjour, je n'arrive plus à me connecter au réseau Wi-Fi
                                de l'établissement depuis ce matin.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="message-item mb-4">
                    <div class="d-flex gap-3">
                        <div class="message-avatar technician-avatar">T</div>

                        <div class="flex-fill">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <strong>Technicien TI</strong>
                                <small class="text-secondary">22 nov. 2026 · 10:15</small>
                            </div>

                            <div class="message-bubble technician-bubble mt-2">
                                yess Ngoulboutara, nous avons bien reçu votre demande.
                                Nous vérifions actuellement le problème réseau.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Réponse publique -->
                <form action="#" method="post">
                    <label for="reponse" class="form-label fw-semibold">
                        Répondre au client
                    </label>

                    <textarea class="form-control mb-3"
                              id="reponse"
                              name="reponse"
                              rows="4"
                              placeholder="Écrivez votre réponse..."
                              required></textarea>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>Envoyer la réponse
                        </button>
                    </div>
                </form>

            </div>

            <!-- Notes privées -->
            <div class="private-notes-card">

                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-lock-fill text-warning fs-5"></i>
                    <h5 class="fw-bold mb-0">Notes privées</h5>
                    <span class="badge text-bg-warning">Équipe TI seulement</span>
                </div>

                <p class="text-secondary small">
                    Ces notes sont visibles uniquement par les techniciens.
                    L'employé ne peut pas les consulter.
                </p>

                <div class="private-note mb-3">
                    <div class="d-flex justify-content-between flex-wrap gap-2">
                        <strong>Technicien TI</strong>
                        <small class="text-secondary">22 nov. 2026 · 10:30</small>
                    </div>
                    <p class="mb-0 mt-2">
                        Vérifier le routeur de l'étage avant de contacter
                        le fournisseur réseau.
                    </p>
                </div>

                <form action="#" method="post">
                    <label for="notePrivee" class="form-label fw-semibold">
                        Ajouter une note privée
                    </label>

                    <textarea class="form-control mb-3"
                              id="notePrivee"
                              name="notePrivee"
                              rows="3"
                              placeholder="Laissez une note pour l'équipe TI..."
                              required></textarea>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-primary px-4">
                            <i class="bi bi-lock me-2"></i>Ajouter la note
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <!-- Gestion du ticket -->
        <div class="col-lg-4">

            <div class="ticket-details-card mb-4">

                <h5 class="fw-bold mb-4">Gestion du ticket</h5>

                <form action="#" method="post">

                    <label for="statut" class="form-label fw-semibold">
                        Modifier le statut
                    </label>

                    <select class="form-select mb-3" id="statut" name="statut">
                        <option value="ouvert">Ouvert</option>
                        <option value="encours" selected>En cours</option>
                        <option value="ferme">Fermé</option>
                    </select>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-repeat me-2"></i>
                        Mettre à jour le statut
                    </button>

                </form>

                <hr class="my-4">

                <h6 class="fw-bold mb-3">Informations</h6>

                <div class="detail-row">
                    <span>Référence</span>
                    <strong>#TK-024</strong>
                </div>

                <div class="detail-row">
                    <span>Employé</span>
                    <strong>Anderson</strong>
                </div>

                <div class="detail-row">
                    <span>Catégorie</span>
                    <strong>Réseau</strong>
                </div>

                <div class="detail-row">
                    <span>Priorité</span>
                    <strong class="text-danger">Urgente</strong>
                </div>

                <div class="detail-row">
                    <span>Date de création</span>
                    <strong>22 nov. 2026</strong>
                </div>

            </div>

        </div>

    </div>

</div>

<?php
$contenu = ob_get_clean();

require 'travailFinal_web_bd_anderson_junior/vue/gabarit.php';
?>
