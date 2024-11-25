/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:46:30
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-25 15:04:41
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
    template: `<h6>Bonjour, {{ name }} !</h6>`,
    data() {
        return {
            name: 'CoreMVC'
        };
    }
});

// Montage de l'application
app.mount('#app');