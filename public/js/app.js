/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:46:30
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-26 00:08:13
 * @ Description: Scripts for the application
 */

// Définition de l'élément HTML où sera montée l'application Vue.js
const app = Vue.createApp({
    data() {
        return {
            <?= $vue_datas??'' ?>
        };
    },
    methods: {
        <?= $vue_methods??'' ?>
    }
});

<?= $vue_components??'' ?>
// Définition du composant "hello-coremvc" pour l'exemple
app.component('hello-coremvc', {
    template: `<p>Bonjour, {{ name }} !</p>`,
    data() {
        return {
            name: 'CoreMVC'
        };
    }
});

app.component('card-img-top', {
    props: ['imgsrc', 'imgalt', 'title', 'text', 'btntext', 'btnlink'],
    template: `<article class="card">
    <img :src="imgsrc" class="card-img-top" :alt="imgalt">
    <div class="card-body">
        <h5 class="card-title">{{ title }}</h5>
        <p class="card-text">
            <slot name="text">{{ text }}</slot>
        </p>
        <a :href="btnlink" class="btn btn-primary">{{ btntext }}</a>
    </div>
</article>`,
});

app.component('carousel-item', {
    props: ['imgsrc', 'imgalt', 'title', 'text', 'active'],
    template: `<div class="carousel-item" :class="{ active: active }">
    <img :src="imgsrc" class="d-block w-100" :alt="imgalt">
    <figcaption class="carousel-caption d-none d-md-block">
        <h5>{{ title }}</h5>
        <p><slot name="text">{{ text }}</slot></p>
    </figcaption>
</div>`,
});

app.component('carousel-indicators', {
    props: ['count', 'id'],
    template: `<div class="carousel-indicators">
    <button 
        v-for="n in count" 
        :key="n" 
        type="button" 
        :data-bs-target="'#' + id" 
        :data-bs-slide-to="n - 1" 
        :class="{ active: n === 1 }" 
        :aria-current="n === 1 ? 'true' : null"
        :aria-label="'Slide ' + n">
    </button>
</div>`,
});

// Montage de l'application
app.mount('#app');