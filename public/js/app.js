/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:46:30
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-29 12:28:48
 * @ Description: Scripts for the application Vue.js
 */

// Définition de l'élément HTML où sera montée l'application Vue.js
const app = Vue.createApp({
    data() {
        return <?= $vue_datas??'' ?>;
    },
    methods: {<?= $vue_methods??'' ?>}
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

// Définition du composant "cookies-consent"
app.component('cookies-consent', {
    template: `<div v-if="showBanner" class="cookie-banner bg-light p-3 fixed-bottom shadow">
    <div class="d-flex justify-content-between align-items-center">
        <p class="mb-0">
            Nous utilisons des cookies pour améliorer votre expérience. Consultez notre <a href="/privacy-policy">Politique de Confidentialité</a>.
        </p>
        <div>
            <button class="btn btn-primary btn-sm me-2" @click="acceptCookies">Accepter</button>
            <button class="btn btn-secondary btn-sm" @click="declineCookies">Refuser</button>
        </div>
    </div>
</div>`,
    data() {
        return {
            showBanner: true // Initialement affiché si aucun consentement n'existe
        };
    },
    methods: {
        acceptCookies() {
            this.setCookie('cookie_consent', 'accepted', 365); // Accepte les cookies pour 1 an
            this.showBanner = false; // Cache le bandeau
        },
        declineCookies() {
            this.setCookie('cookie_consent', 'declined', 365); // Refuse les cookies pour 1 an
            this.showBanner = false; // Cache le bandeau
        },
        setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
        },
        getCookie(name) {
            const cookies = document.cookie.split('; ');
            for (let cookie of cookies) {
                const [key, value] = cookie.split('=');
                if (key === name) {
                    return value;
                }
            }
            return null;
        },
        checkCookieConsent() {
            const consent = this.getCookie('cookie_consent');
            if (consent === 'accepted' || consent === 'declined') {
                this.showBanner = false; // Bandeau déjà accepté ou refusé
            }
        }
    },
    mounted() {
        this.checkCookieConsent(); // Vérifie le consentement au chargement
    }
});


// Montage de l'application
app.mount('#app');