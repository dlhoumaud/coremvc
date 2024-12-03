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
                        <a class="nav-link active" aria-current="page" href="/"><i class="fas fa-house"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about"><?= l('about') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact"><?= l('contact-us') ?></a>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (!isset($_SESSION['user'])): ?>
                                    <li class="dropdown-item">
                                        <a class="nav-link" href="/login"><i class="fas fa-right-to-bracket"></i> <?= l('login') ?></a>
                                    </li>
                                <?php else: ?>
                                    <li class="dropdown-item"><a class="nav-link" href="/user/<?= $_SESSION['user']['id'] ?>"><i class="fas fa-address-card"></i> <?= l('my_profil') ?></a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="dropdown-item"><a class="nav-link" href="/admin/dashboard"><i class="fas fa-chart-line"></i> <?= l('dashboard') ?></a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="dropdown-item"><a class="nav-link" href="/logout"><i class="fas fa-right-from-bracket"></i></i> <?= l('logout') ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex align-items-center" role="search" method="POST">
                        <div class="input-group">
                            <input 
                                class="form-control shadow-sm" 
                                type="search" 
                                placeholder="<?= l('search_placeholder') ?>" 
                                aria-label="<?= l('search') ?>">
                            <button 
                                class="btn btn-success shadow-sm" 
                                type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- END MENU-->
</header>