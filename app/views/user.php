<div class="position-relative overflow-hidden p-3 pt-md-5 mt-md-3 text-center bg-body-tertiary">
    <div class="col-md-6 p-lg-5 mx-auto my-5">
        <h1 class="display-3 fw-bold text-primary">{{ firstname }} {{ lastname }}</h1>
        <h3 class="fw-normal text-muted mb-3">{{ email }}</h3>
        <p class="lead text-dark">Développeur passionné, toujours à la recherche de nouvelles opportunités pour améliorer et partager mes connaissances.</p>
    </div>
</div>

<div class="d-flex justify-content-center mt-2">
    <card-img-top
        cardclass='shadow-lg'
        cardstyle='width:18rem;'
        imgsrc='/assets/images/CoreMVC.png'
        imgalt='À propos de moi'
        title='À propos de moi'
        text="Je suis un développeur Web passionné par la création d'applications et de solutions logicielles. Mon expertise inclut le développement front-end et back-end, ainsi que la conception de frameworks MVC comme CoreMVC."
        btntext='Voir plus'
        btnclass='btn-primary w-100'
        :btnclick='click'
        :btnmouseenter='mouseEnter'
        :btnmouseleave='mouseLeave'>
    </card-img-top>
</div>