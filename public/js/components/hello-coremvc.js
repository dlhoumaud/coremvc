// Définition du composant "hello-coremvc" pour l'exemple
export default (app) => {
    app.component('hello-coremvc', {
        props: ['text'],
        template: `<p>{{ text }} !</p>`,
        data() {
            return {
                name: 'CoreMVC'
            };
        }
    });
}