<header>
    <!-- MENU-->
    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="/assets/images/logo-min.png" alt="Logo" class="w-25"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#NavBarMenu" aria-controls="NavBarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="NavBarMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/"><i class="fas fa-home"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Informations
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/user/1">Utilisateur</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/login">Connexion</a></li>
                        <li><a class="dropdown-item" href="/about"><?= l('about') ?></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item disabled" href="/contact" aria-disabled="true"><?= l('contact') ?></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about"><?= l('about') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact"><?= l('contact') ?></a>
                </li>
                </ul>
                <form class="d-flex align-items-center" role="search" method="POST">
                    <div class="input-group">
                        <input 
                            class="form-control shadow-sm" 
                            type="search" 
                            placeholder="Recherche..." 
                            aria-label="Search">
                        <button 
                            class="btn btn-success shadow-sm" 
                            type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <!-- END MENU-->
</header>