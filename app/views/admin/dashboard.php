<div class="container my-5">
  <div class="container-fluid h-100">
    <div class="row h-100">
      <!-- Sidebar -->
      <div class="col-md-3 col-lg-2 p-3 my-5 sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="/admin/dashboard"><?= l('dashboard') ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/admin/users"><?= l('users') ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><?= l('settings') ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><?= l('reports') ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/logout"><?= l('logout') ?></a>
          </li>
        </ul>
      </div>
      <!-- Main Content -->
      <div class="col-md-9 col-lg-10 content">
        <h1 class="text-center my-5"><?= l('welcome_dashboard') ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fa-solid fa-house text-primary"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= l('dashboard') ?></li>
            </ol>
        </nav>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title"><?= l('users') ?></h5>
                <i class="fa-solid fa-users fa-3x text-primary mb-3 text-center"></i>
                <p class="card-text"><?= l('users_description') ?></p>
                <a class="btn btn-primary" href="/admin/users"><?= l('configure') ?></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title"><?= l('settings') ?></h5>
                <i class="fa-solid fa-gears fa-3x text-primary mb-3 text-center"></i>
                <p class="card-text"><?= l('settings_description') ?></p>
                <a class="btn btn-primary" href="#"><?= l('configure') ?></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title"><?= l('reports') ?></h5>
                <i class="fa-solid fa-file-contract fa-3x text-primary mb-3 text-center"></i>
                <p class="card-text"><?= l('reports_description') ?></p>
                <a class="btn btn-primary" href="#"><?= l('configure') ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>