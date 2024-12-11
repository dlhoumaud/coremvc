<div class="container my-5">
  <div class="container-fluid h-100">
    <div class="row h-100">
      <!-- Sidebar -->
      <?= view('admin/includes/sidebar'); ?>
      <!-- Main Content -->
      <div class="col-md-9 col-lg-10 content">
        <h1 class="text-center my-5"><?= l('settings') ?></h1>
        <breadcrumb
            :fields="[
                {link: '/', icon: 'fa-house', iconcolor: 'text-primary'},
                {link: '/admin/dashboard', text: '<?= l('dashboard') ?>'},
                {class: 'active', text: '<?= l('settings') ?>'}
            ]"
        ></breadcrumb>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4">
            <card-title-icon-top
                    icon='fa-route'
                    iconcolor='text-primary'
                    iconsize='fa-3x'
                    title='<?= l('routes') ?>'
                    btntext='<?= l('configure') ?>'
                    btnlink='/admin/routes'
                    btnclass='btn-primary'>
                    <template #text>
                        <?= l('routes_description') ?>
                    </template>
            </card-title-icon-top>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <card-title-icon-top
                    icon='fa-language'
                    iconcolor='text-primary'
                    iconsize='fa-3x'
                    title='<?= l('languages') ?>'
                    btntext='<?= l('configure') ?>'
                    btnlink='/admin/languages'
                    btnclass='btn-primary'>
                    <template #text>
                        <?= l('languages_description') ?>
                    </template>
            </card-title-icon-top>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <card-title-icon-top
                    icon='fa-eye'
                    iconcolor='text-primary'
                    iconsize='fa-3x'
                    title='<?= l('views') ?>'
                    btntext='<?= l('configure') ?>'
                    btnlink='/admin/views'
                    btnclass='btn-primary'>
                    <template #text>
                        <?= l('views_description') ?>
                    </template>
            </card-title-icon-top>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>