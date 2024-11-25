<div class="position-relative overflow-hidden p-3 pt-md-5 mt-md-3 text-center bg-body-tertiary">
    <div class="col-md-6 p-lg-5 mx-auto my-5">
        <h1 class="display-3 fw-bold text-primary">{{ firstname }} {{ lastname }}</h1>
        <h3 class="fw-normal text-muted mb-3">{{ email }}</h3>
        <p class="lead text-dark">Développeur passionné, toujours à la recherche de nouvelles opportunités pour améliorer et partager mes connaissances.</p>
    </div>
</div>

<div class="d-flex justify-content-center mt-2">
    <div class="card shadow-lg" style="width: 18rem;">
        <img src="/assets/images/CoreMVC.png" class="card-img-top" alt="Profile Image">
        <div class="card-body">
            <h5 class="card-title text-center">À propos de moi</h5>
            <p class="card-text">Je suis un développeur Web passionné par la création d'applications et de solutions logicielles. Mon expertise inclut le développement front-end et back-end, ainsi que la conception de frameworks MVC comme CoreMVC.</p>
            <a href="#" @click="click" @mouseenter="mouseEnter" @mouseleave="mouseLeave" class="btn btn-primary w-100">Voir plus</a>
        </div>
    </div>
</div>