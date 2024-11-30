// Définition du composant "cookies-consent"
export default (app) => {
    app.component('cookies-consent', {
        template: `<div v-if="showBanner" class="cookie-banner bg-light p-3 fixed-bottom shadow-top">
        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0">
                Nous utilisons des cookies pour améliorer votre expérience. Consultez notre <a href="/privacy-policy">Politique de Confidentialité</a>.
            </p>
            <div>
                <button class="btn btn-link btn-sm" @click="showPreferences = true">Personnaliser</button>
                <button class="btn btn-primary btn-sm me-2" @click="acceptCookies">Accepter</button>
                <button class="btn btn-secondary btn-sm" @click="declineCookies">Refuser</button>
            </div>
        </div>
        <div v-if="showPreferences" class="cookie-preferences mt-3 p-3 border rounded bg-white">
        <h5>Préférences des cookies</h5>
        <div v-for="(type, key) in cookieTypes" :key="key" class="form-check">
            <input
            type="checkbox"
            :id="key"
            class="form-check-input"
            v-model="cookiePreferences[key]"
            :disabled="key === 'essential'"
            />
            <label :for="key" class="form-check-label">{{ type }}</label>
        </div>
        <button class="btn btn-success btn-sm mt-3" @click="savePreferences">Enregistrer mes choix</button>
        </div>
    </div>`,
    data() {
        return {
            showBanner: true,
            showPreferences: false,
            cookiePreferences: {
            essential: true, // Toujours activé
            analytics: false,
            ads: false
            },
            cookieTypes: {
            essential: 'Cookies essentiels',
            analytics: 'Cookies analytiques',
            ads: 'Cookies publicitaires'
            }
        };
        },
        methods: {
        acceptAllCookies() {
            for (let key in this.cookiePreferences) {
            this.cookiePreferences[key] = true;
            }
            this.savePreferences();
        },
        declineCookies() {
            for (let key in this.cookiePreferences) {
            if (key !== 'essential') {
                this.cookiePreferences[key] = false;
            }
            }
            this.savePreferences();
        },
        savePreferences() {
            const consentData = {
            preferences: this.cookiePreferences,
            timestamp: new Date().toISOString()
            };
            this.setCookie('cookie_consent', JSON.stringify(consentData), 365);
            this.showBanner = false;
        },
        setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
            document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
        },
        checkCookieConsent() {
            const consent = this.getCookie('cookie_consent');
            if (consent) {
            this.showBanner = false;
            }
        },
        getCookie(name) {
            const cookies = document.cookie.split('; ');
            for (let cookie of cookies) {
            const [key, value] = cookie.split('=');
            if (key === name) {
                return JSON.parse(value);
            }
            }
            return null;
        }
        },
        mounted() {
        this.checkCookieConsent();
        }
    });
}