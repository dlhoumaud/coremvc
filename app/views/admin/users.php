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
            <a class="nav-link" href="#"><?= l('users') ?></a>
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
        <h1 class="text-center my-5"><?= l('users_list') ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fa-solid fa-house text-primary"></i></a></li>
                <li class="breadcrumb-item"><a href="/admin/dashboard"><?= l('dashboard') ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= l('users') ?></li>
            </ol>
        </nav>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Nom d'utilisateur</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <th scope="row"><?= $user['id'] ?></th>
                            <td><?= $user['firstname'] ?></td>
                            <td><?= $user['lastname'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="btn btn-primary" data-bs-toggle="modal" id="btn-modify" data-bs-target="#modify" onclick="modifyUser(<?= $user['id'] ?>, {firstname:'<?= $user['firstname'] ?>', lastname:'<?= $user['lastname'] ?>', username:'<?= $user['username'] ?>', email:'<?= $user['email'] ?>'})"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" id="btn-delete" data-bs-target="#delete" onclick="deleteUser(<?= $user['id'] ?>, {firstname:'<?= $user['firstname'] ?>', lastname:'<?= $user['lastname'] ?>'})"><i class="fas fa-eraser"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modify" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down" >
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary" id="modifyLabel"><?= l('modify') ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-modify">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" name="firstname" id="floatingFirstname" placeholder="<?= l('firstname') ?>" value="" required>
                        <label for="floatingFirstname"><?= l('firstname') ?></label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" name="lastname" id="floatingName" placeholder="<?= l('lastname') ?>" value="" required>
                        <label for="floatingName"><?= l('lastname') ?></label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" name="username" id="floatingUsername" placeholder="<?= l('username') ?>" value="" required>
                        <label for="floatingUsername"><?= l('username') ?></label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="email" class="form-control" name="email" id="floatingEmail" placeholder="<?= l('email_address') ?>" value="" required>
                        <label for="floatingEmail"><?= l('email_address') ?></label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="<?= l('password') ?>" value="">
                        <label for="floatingPassword"><?= l('password') ?></label>
                    </div>
                    <div class="btn-group w-100 py-2" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                        <button type="button" class="btn btn-secondary " data-bs-dismiss="modal"><i class="fas fa-cancel"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down" >
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary" id="deleteLabel"><?= l('delete') ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Êtes-vous sur de vouloir supprimer <span id="delete-fullname"></span> ?</p>
                <div class="btn-group w-100 py-2" role="group" aria-label="Basic example">
                    <a class="btn btn-danger" id="link-delete" href=""><i class="fas fa-trash"></i></a>
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal"><i class="fas fa-cancel"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modifyUser(id, obj) {
        $('#form-modify').action(`/admin/user/${id}/edit`);
        $('#floatingFirstname').value(obj.firstname);
        $('#floatingName').value(obj.lastname);
        $('#floatingUsername').value(obj.username);
        $('#floatingEmail').value(obj.email);
    }
    function deleteUser(id, obj) {
        $('#delete-fullname').text(`${obj.firstname} ${obj.lastname}`);
        $('#link-delete').href(`/admin/user/${id}/delete`);
    }
</script>