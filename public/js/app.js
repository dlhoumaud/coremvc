/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:46:30
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-18 13:23:35
 * @ Description: Scripts pour l'application vue.js
 */

for (const method in window.vueMethods) {
    if (typeof window.vueMethods[method] === "string") {
        window.vueMethods[method] = new Function("return " + window.vueMethods[method])();
    }
}

/**
 * Crée une nouvelle instance d'application Vue.js avec les données et méthodes spécifiées.
 * Les données sont récupérées de l'objet mondial de fenêtre.vuedatas »et les méthodes
 * sont récupérés de l'objet mondial `window.vueMethods '.
 */
const app = Vue.createApp({
    data() {
        return window.vueDatas;
    },
    methods: window.vueMethods,
});

window.vueComponents.push('cookies-consent.min');
// Charger tous les composants de manière asynchrone
const loadComponents = window.vueComponents.map(component =>
    import(`/js/components/${component}.js`)
        .then(module => {
            if (module.default) {
                module.default(app);
            } else {
                console.error(`Le composant ${component} n'a pas de "default".`);
            }
        })
        .catch(err => {
            console.error(`Erreur lors du chargement du composant ${component}:`, err);
        })
);

// Attendre que tous les composants soient chargés avant de monter l'application
Promise.all(loadComponents)
    .then(() => {
        app.mount('#app');
    })
    .catch(err => {
        console.error('Erreur lors du chargement des composants:', err);
    });
