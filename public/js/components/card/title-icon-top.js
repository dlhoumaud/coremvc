export default (app) => {
    app.component('card-title-icon-top', {
        props: ["cardclass", "cardstyle", "icon", "iconcolor", "iconsize", "title", "text", "btntext", "btnlink", "btnclass", "btnclick" , "btnmouseenter", "btnmouseleave"],
        template: `<article :class="['card', 'h-100', cardclass]" :style="cardstyle">
        <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title text-center mb-3">{{ title }}</h5>
            <i :class="['fa-solid', icon, iconcolor, iconsize, 'mb-3', 'text-center']"></i>
            <p class="card-text">
                <slot name="text">{{ text }}</slot>
            </p>
            <a :href="btnlink" @click="btnclick" @mouseenter="btnmouseenter" @mouseleave="btnmouseleave" :class="['btn', btnclass]">{{ btntext }}</a>
        </div>
    </article>`,
    });
}