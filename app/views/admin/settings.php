<div class="container my-5">
  <div class="container-fluid h-100">
    <div class="row h-100">
      <!-- Sidebar -->
      <?= view('admin/includes/sidebar'); ?>
      <!-- Main Content -->
      <div class="col-md-9 col-lg-10 content">
        <h1 class="text-center my-5"><?= l('welcome_dashboard') ?></h1>
        <breadcrumb
            :fields="[
                {link: '/', icon: 'fa-house', iconcolor: 'text-primary'},
                {link: '/admin/dashbord', text: '<?= l('dashboard') ?>'},
                {class: 'active', text: '<?= l('settings') ?>'}
            ]"
        ></breadcrumb>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4">
            <card-title-icon-top
                    icon='fa-users'
                    iconcolor='text-primary'
                    iconsize='fa-3x'
                    title='<?= l('users') ?>'
                    btntext='<?= l('configure') ?>'
                    btnlink='/admin/users'
                    btnclass='btn-primary'>
                    <template #text>
                        <?= l('users_description') ?>
                    </template>
            </card-title-icon-top>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <card-title-icon-top
                    icon='fa-gears'
                    iconcolor='text-primary'
                    iconsize='fa-3x'
                    title='<?= l('settings') ?>'
                    btntext='<?= l('configure') ?>'
                    btnlink='/admin/settings'
                    btnclass='btn-primary'>
                    <template #text>
                        <?= l('settings_description') ?>
                    </template>
            </card-title-icon-top>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <card-title-icon-top
                    icon='fa-file-contract'
                    iconcolor='text-primary'
                    iconsize='fa-3x'
                    title='<?= l('reports') ?>'
                    btntext='<?= l('configure') ?>'
                    btnlink='/admin/reports'
                    btnclass='btn-primary'>
                    <template #text>
                        <?= l('reports_description') ?>
                    </template>
            </card-title-icon-top>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>