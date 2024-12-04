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
                    <th scope="col"><?= l("firstname") ?></th>
                    <th scope="col"><?= l("lastname") ?></th>
                    <th scope="col"><?= l("username") ?></th>
                    <th scope="col"><?= l("email") ?></th>
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
                                    <button class="btn btn-primary" data-bs-toggle="modal" id="btn-modify" data-bs-target="#modal-modify" onclick="modifyUser(<?= $user['id'] ?>, {firstname:'<?= $user['firstname'] ?>', lastname:'<?= $user['lastname'] ?>', username:'<?= $user['username'] ?>', email:'<?= $user['email'] ?>'})"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" id="btn-delete" data-bs-target="#modal-delete" onclick="deleteUser(<?= $user['id'] ?>, {firstname:'<?= $user['firstname'] ?>', lastname:'<?= $user['lastname'] ?>'})"><i class="fas fa-eraser"></i></button>
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

<modal-form
    id="modal-modify"
    idlabel="modal-modify-label"
    title="<?= l('modify') ?>"
    titlecolor="text-primary"
    action=""
    formid="form-modify"
    method="post"
    okid="modal-modify-btn"
    okicon="fa-check"
    okcolor="btn-success"
    cancel=""
    cancelicon="fa-cancel"
    cancelcolor="btn-secondary">
    <template #form>
        <input-floating
        mb="mb-1"
        :fields="[
            {name: 'firstname', id: 'floatingFirstname', type: 'text', value: '', placeholder: '<?= l("firstname") ?>', required: true},
            {name: 'lastname', id: 'floatingLastname', type: 'text', value: '', placeholder: '<?= l("lastname") ?>', required: true},
            {name: 'username', id: 'floatingUsername', type: 'text', value: '', placeholder: '<?= str_replace("'","\\'", l("username")) ?>', required: true},
            {name: 'email', id: 'floatingEmail', type: 'email', value: '', placeholder: '<?= l("email") ?>', required: true},
            {name: 'password', id: 'floatingPassword', type: 'password', value: '', placeholder: '<?= l("password") ?>', required: false}
        ]"
        ></input-floating>
    </template>
</modal-form>

<modal-confirm
    id="modal-delete"
    idlabel="modal-delete-label"
    title="<?= l('delete') ?>"
    titlecolor="text-danger"
    ok=""
    okid="modal-delete-link"
    okhref=""
    okicon="fa-trash"
    okcolor="btn-danger"
    cancel=""
    cancelicon="fa-cancel"
    cancelcolor="btn-secondary">
    <template #message>
        <p class="text-center">Êtes-vous sur de vouloir supprimer <span id="modal-delete-fullname"></span> ?</p>
    </template>
</modal-confirm>

<script type="text/javascript">
    function modifyUser(id, obj) {
        $('#form-modify').action(`/admin/user/${id}/edit`);
        $('#floatingFirstname').value(obj.firstname);
        $('#floatingLastname').value(obj.lastname);
        $('#floatingUsername').value(obj.username);
        $('#floatingEmail').value(obj.email);
    }
    function deleteUser(id, obj) {
        $('#modal-delete-fullname').text(`${obj.firstname} ${obj.lastname}`);
        $('#modal-delete-link').href(`/admin/user/${id}/delete`);
    }
</script>