
<nav class="navbar navbar-expand-lg bg-white py-3 border-bottom">
    <div class="container">

        
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <div class="brand-icon">
                <i class="bi bi-headset"></i>
            </div>

            <div class="d-flex flex-column">
                <span class="fw-bold text-dark">SUPPORT TI</span>
                <small class="text-secondary">ANDERSON & JUNIOR</small>
            </div>
        </a>


        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuPrincipal">

            <span class="navbar-toggler-icon"></span>

        </button>


        <div class="collapse navbar-collapse" id="menuPrincipal">

            <ul class="navbar-nav mx-auto gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link active" href="index.php?action=afficherPageAccueilEmploye">
                        Tableau de bord
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=afficherPageMesTickets">
                        Mes tickets
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=afficherPageNouveauTicket">
                        Nouveau ticket
                    </a>
                </li>

            </ul>

        


            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">

                <button class="btn btn-light rounded-circle position-relative"
                        type="button">

                    <i class="bi bi-bell"></i>

                    <span class="notification-dot"></span>

                </button>

                <div class="d-flex align-items-center gap-2">

                    <div class="user-avatar">
                        A
                    </div>

                    <div class="d-none d-md-block">
                        <div class="fw-semibold small">Anderson</div>
                        <small class="text-secondary">Employé</small>
                    </div>

                </div>

            </div>

        </div>

    </div>
</nav>
