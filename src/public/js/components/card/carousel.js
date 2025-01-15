export default (app) => {
    app.component('card-carousel', {
        props: ["cardclass", "cardstyle", "carousel", "carouselid", "title", "text", "btntext", "btnlink", "btnclass", "btnclick" , "btnmouseenter", "btnmouseleave"],
        template: `<article :class="['card', 'h-100', cardclass]" :style="cardstyle">
        <div :id="carouselid" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true" data-bs-interval="true">
            <div class="carousel-inner">
                <slot name="carousel">{{ carousel }}</slot>
            </div>
        </div>
        <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">
                <slot name="text">{{ text }}</slot>
            </p>
            <a :href="btnlink" @click="btnclick" @mouseenter="btnmouseenter" @mouseleave="btnmouseleave" :class="['btn', btnclass, 'mt-auto', 'align-self-start']">{{ btntext }}</a>
        </div>
    </article>`,
    });
}