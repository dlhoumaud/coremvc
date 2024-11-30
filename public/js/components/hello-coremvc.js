// Définition du composant "hello-coremvc" pour l'exemple
export default (app) => {
    app.component('hello-coremvc', {
        template: `<p>Bonjour, {{ name }} !</p>`,
        data() {
            return {
                name: 'CoreMVC'
            };
        }
    });
}