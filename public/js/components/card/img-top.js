export default (app) => {
    app.component('card-img-top', {
        props: ["cardclass", "cardstyle", "imgsrc", "imgalt", "title", "text", "btntext", "btnlink", "btnclass", "btnclick" , "btnmouseenter", "btnmouseleave"],
        template: `<article :class="['card', cardclass]" :style="cardstyle">
        <img :src="imgsrc" class="card-img-top" :alt="imgalt">
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">
                <slot name="text">{{ text }}</slot>
            </p>
            <a :href="btnlink" @click="btnclick" @mouseenter="btnmouseenter" @mouseleave="btnmouseleave" :class="['btn', btnclass]">{{ btntext }}</a>
        </div>
    </article>`,
    });
}