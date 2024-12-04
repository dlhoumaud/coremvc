export default (app) => {
    app.component('card-img-top', {
        props: ["cardclass", "cardstyle", "imgsrc", "imgalt", "title", "text", "btntext", "btnlink", "btnclass", "btnclick" , "btnmouseenter", "btnmouseleave"],
        template: `<article :class="['card', 'h-100', cardclass]" :style="cardstyle">
        <img :src="imgsrc" class="card-img-top" :alt="imgalt">
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