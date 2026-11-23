
<?php

$titreOnglet = 'Détail du ticket';
$afficherMenu = true;

ob_start();
?>

<div class="container py-5">


    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <a href="index.php?action=afficherPageMesTickets"
               class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-left me-2"></i>Retour à mes tickets
            </a>

            <h2 class="fw-bold mt-3 mb-1">Problème de connexion Wi-Fi</h2>
            <p class="text-secondary mb-0">Ticket #TK-001 · Créé le 18 novembre 2026</p>
        </div>

        <span class="badge rounded-pill text-bg-warning px-3 py-2">
            En cours
        </span>
    </div>

    <div class="row g-4">


        <div class="col-lg-8">

            <div class="ticket-conversation">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Conversation</h5>
                    <span class="text-secondary small">2 messages</span>
                </div>

                <div class="message-item mb-4">
                    <div class="d-flex gap-3">
                        <div class="message-avatar employee-avatar">A</div>

                        <div class="flex-fill">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <strong>Ngoulboutara</strong>
                                <small class="text-secondary">18 nov. 2026 · 09:30</small>
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
                                <small class="text-secondary">18 nov. 2026 · 10:15</small>
                            </div>

                            <div class="message-bubble technician-bubble mt-2">
                                Bonjour Ngoulboutara, nous avons bien reçu votre demande.
                                Nous sommes en train de vérifier le problème réseau.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">


                <form action="#" method="post">
                    <label for="message" class="form-label fw-semibold">
                        Votre message
                    </label>

                    <textarea
                        class="form-control mb-3"
                        id="message"
                        name="message"
                        rows="4"
                        placeholder="Écrivez votre réponse ici..."
                        required></textarea>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>Envoyer
                        </button>
                    </div>
                </form>

            </div>
        </div>


        <div class="col-lg-4">

            <div class="ticket-details-card mb-4">
                <h5 class="fw-bold mb-4">Informations du ticket</h5>

                <div class="detail-row">
                    <span>Référence</span>
                    <strong>#TK-001</strong>
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
                    <span>Statut</span>
                    <strong class="text-warning">En cours</strong>
                </div>

                <div class="detail-row">
                    <span>Date de création</span>
                    <strong>18 nov. 2026</strong>
                </div>
            </div>
<!--
            <div class="ticket-details-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="info-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Besoin d'aide ?</h6>
                </div>

                <p class="text-secondary small mb-0">
                    Vous pouvez communiquer avec notre équipe TI directement
                    dans cette conversation pour obtenir des nouvelles de votre demande.
                </p>
            </div>
-->
        </div>
    </div>
</div>

<?php
$contenu = ob_get_clean();

require 'travailFinal_web_bd_anderson_junior/vue/gabarit.php';
?>
