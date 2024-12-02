<!-- CARROUSEL-->
<div id="HomeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true" data-bs-interval="true">
    <carousel-indicators :count="3" id="HomeCarousel"></carousel-indicators>
    <div class="carousel-inner">
        <carousel-item
            imgsrc="/assets/images/slides/000.png"
            imgalt="<?= l('welcome') ?>"
            title="<?= l('welcome') ?>"
            text="<?= l('framework_for_all') ?>"
            interval="10000"
            :active="true">
        </carousel-item>
        <carousel-item
            imgsrc="/assets/images/slides/001.png"
            imgalt="<?= l('framework_mvc_php') ?>"
            title="<?= l('framework_mvc_php') ?>"
            text="<?= l('easy_dev') ?>"
            interval="10000"
            :active="false">
        </carousel-item>
        <carousel-item
            imgsrc="/assets/images/slides/002.png"
            imgalt="<?= l('framework_no_deps') ?>"
            title="<?= l('framework_no_deps') ?>"
            text="<?= l('no_composer') ?>"
            interval="10000"
            :active="false">
        </carousel-item>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#HomeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden"><?= l('previous') ?></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#HomeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden"><?= l('next') ?></span>
    </button>
</div>
<!-- END CARROUSEL-->
<div class="container mt-5 mb-5">
    <!-- CARDS-->
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
            <card-img-top
                imgsrc='/assets/images/bg.png'
                imgalt='<?= l('card_image') ?>'
                title='<?= l('name_site') ?>'
                text="<?= l('easy_usage') ?>"
                btntext='<?= l('view_more') ?>'
                btnlink='#'
                btnclass='btn-primary'>
            </card-img-top>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
            <card-img-top
                imgsrc='/assets/images/bg.png'
                imgalt='<?= l('card_image') ?>'
                title='<?= l('card_title_goals') ?>'
                btntext='<?= l('view_more') ?>'
                btnlink='#'
                btnclass='btn-primary'>
                <template #text>
                    <?= l('easy_dev_text') ?>
                </template>
            </card-img-top>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
            <card-img-top
                imgsrc='/assets/images/bg.png'
                imgalt='<?= l('card_image') ?>'
                title='<?= l('card_title') ?>'
                text='<?= l('card_text') ?>'
                btntext='<?= l('view_more') ?>'
                btnlink='#'
                btnclass='btn-primary'>
            </card-img-top>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
            <card-img-top
                imgsrc='/assets/images/bg.png'
                imgalt='<?= l('card_image') ?>'
                title='<?= l('card_title') ?>'
                btntext='<?= l('view_more') ?>'
                btnlink='#'
                btnclass='btn-primary'>
                <template #text>
                    <hello-coremvc text='<?= l('welcome') ?>'></hello-coremvc>
                </template>
            </card-img-top>
        </div>
    </div>
    <!-- END CARDS-->
</div>