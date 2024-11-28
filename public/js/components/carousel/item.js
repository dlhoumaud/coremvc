app.component("carousel-item", {
    props: ["imgsrc", "imgalt", "title", "text", "interval", "active"],
    template: `<div class="carousel-item" :class="{ active: active }" :data-bs-interval="interval">
    <img :src="imgsrc" class="d-block w-100" :alt="imgalt">
    <figcaption class="carousel-caption d-none d-md-block">
        <h5>{{ title }}</h5>
        <p><slot name="text">{{ text }}</slot></p>
    </figcaption>
</div>`,
});