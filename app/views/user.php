<div class="position-relative overflow-hidden p-3 pt-md-5 mt-md-3 text-center bg-body-tertiary">
    <div class="col-md-6 p-lg-5 mx-auto">
        <h1 class="display-3 fw-bold text-primary">{{ firstname }} {{ lastname }}</h1>
        <h3 class="fw-normal text-muted">{{ email }}</h3>
        <p class="lead fw-small text-muted">{{ role }}</p>
        <p class="lead fw-small text-muted">{{ birthdate }}</p>
    </div>
</div>

<div class="d-flex justify-content-center mt-2">
    <card-img-top
        cardclass='shadow-lg'
        cardstyle='width:18rem;'
        :imgsrc='avatar'
        imgalt='<?= l('user_about') ?>'
        title='<?= l('user_about') ?>'
        :text="bio"
        btntext='<?= l('view_more') ?>'
        btnclass='btn-primary w-100'
        :btnclick='click'
        :btnmouseenter='mouseEnter'
        :btnmouseleave='mouseLeave'>
    </card-img-top>
</div>