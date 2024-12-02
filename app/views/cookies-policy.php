<div class="container my-5">
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
        <div class="col-md-6 p-lg-2 mx-auto my-5">
        <h1 class="display-3 fw-bold"><?= l('title') ?></h1>
        <h3 class="fw-normal text-muted mb-3"><?= l('updated_date') ?></h3>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

    <?= l('content') ?>

    <footer class="text-center mt-5">
        <p class="text-muted">&copy; <?= date('Y') ?> - <?= l('name_site') ?>. <?= l('all_rights_reserved') ?>.</p>
    </footer>
</div>
