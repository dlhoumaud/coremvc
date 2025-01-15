/**
 * Defines a Vue.js component for rendering a carousel of items.
 * 
 * @param {object} app - The Vue.js application instance.
 * @returns {void}
 */
export default (app) => {
    app.component("carousel-items", {
        props: {
            fields: {
                type: Array,
                required: true,
            }
        },
        template: `<div v-for="field in fields" :key="field.id" class="carousel-item" :class="{ active: field.active }" :data-bs-interval="field.interval">
        <img :src="field.imgsrc" class="d-block w-100" :alt="field.imgalt">
        <figcaption class="carousel-caption d-none d-md-block">
            <h5>{{ field.title }}</h5>
            <p><slot name="text" :field="field">{{ field.text }}</slot></p>
        </figcaption>
    </div>`
    });
}