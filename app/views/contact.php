<div class="container my-5">
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 15px;">
            <form>
                <div class="text-center mb-4">
                    <img class="mb-4" src="assets/images/logo-min.png" alt="Logo" width="72" height="57">
                    <h1 class="h3 mb-3 fw-normal text-primary"><?= l('contact-us') ?></h1>
                    <p class="text-muted"><?= l('introduction') ?></p>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" placeholder="<?= l('name') ?>" required>
                    <label for="floatingName"><?= l('name') ?></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
                    <label for="floatingEmail"><?= l('email') ?></label>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" id="floatingMessage" placeholder="<?= l('message') ?>..." style="height: 150px;" required></textarea>
                    <label for="floatingMessage"><?= l('message') ?></label>
                </div>

                <button class="btn btn-primary w-100 py-2" type="submit"><i class="fa-regular fa-paper-plane"></i> <?= l('send') ?></button>

                <p class="mt-4 mb-0 text-center text-muted">
                    <small><?= l('outro') ?></small>
                </p>
            </form>
        </div>
    </div>
</div>
