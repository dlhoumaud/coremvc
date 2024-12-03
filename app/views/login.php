<div class="container my-5">
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 15px;">
            <form method="post" action="/login" class="needs-validation" novalidate>
                <div class="text-center mb-4">
                    <img class="mb-4" src="assets/images/logo-min.png" alt="Logo" width="72" height="57">
                    <h1 class="h3 mb-3 fw-normal text-primary"><?= l('login_signin') ?></h1>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput"><?= l('login_email_address') ?></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="<?= l('login_password') ?>" required>
                    <label for="floatingPassword"><?= l('login_password') ?></label>
                </div>

                <div class="form-check text-start my-3">
                    <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        <?= l('login_remender_me') ?>
                    </label>
                </div>

                <button class="btn btn-primary w-100 py-2" type="submit"><?= l('login_signin_btn') ?></button>

                <p class="mt-4 mb-0 text-center">
                    <small><?= l('login_signup_text') ?> <a href="#"><?= l('login_signup_here') ?></a></small>
                </p>
            </form>
        </div>
    </div>
</div>
