<!-- CARROUSEL-->
<div id="HomeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true" data-bs-interval="true">
    <carousel-indicators :count="3" id="HomeCarousel"></carousel-indicators>
    <div class="carousel-inner">
        <carousel-item
            imgsrc="/assets/images/slides/000.png"
            imgalt="Bienvenue sur CoreMVC"
            title="Bienvenue sur CoreMVC"
            text="Un framework pour tous.."
            interval="10000"
            :active="true">
        </carousel-item>
        <carousel-item
            imgsrc="/assets/images/slides/001.png"
            imgalt="Framework MVC en PHP"
            title="Framework MVC en PHP"
            text="Développer facilement."
            interval="10000"
            :active="false">
        </carousel-item>
        <carousel-item
            imgsrc="/assets/images/slides/002.png"
            imgalt="Un framework sans dépendance"
            title="Un framework sans dépendance"
            text="Aucun contrainte lié à composer"
            interval="10000"
            :active="false">
        </carousel-item>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#HomeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#HomeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- END CARROUSEL-->
<div class="container mt-5 mb-5">
    <!-- CARDS-->
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
            <card-img-top
                imgsrc='/assets/images/bg.png'
                imgalt='Image de la carte'
                title='CoreMVC'
                text="Est un framework PHP facile d'utilisation."
                btntext='Voir plus'
                btnlink='#'
                btnclass='btn-primary'>
            </card-img-top>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
            <card-img-top
                imgsrc='/assets/images/bg.png'
                imgalt='Image de la carte'
                title='Objectifs'
                btntext='Voir plus'
                btnlink='#'
                btnclass='btn-primary'>
                <template #text>
                    <p>Développer facilement</p>
                    <p>Développer proprement</p>
                </template>
            </card-img-top>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
            <card-img-top
                imgsrc='/assets/images/bg.png'
                imgalt='Image de la carte'
                title='Titre carte'
                text='Petit exemple de contenu pour la carte.'
                btntext='Voir plus'
                btnlink='#'
                btnclass='btn-primary'>
            </card-img-top>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
            <card-img-top
                imgsrc='/assets/images/bg.png'
                imgalt='Image de la carte'
                title='Titre carte'
                btntext='Voir plus'
                btnlink='#'
                btnclass='btn-primary'>
                <template #text>
                    <hello-coremvc></hello-coremvc>
                </template>
            </card-img-top>
        </div>
    </div>
    <!-- END CARDS-->
</div>