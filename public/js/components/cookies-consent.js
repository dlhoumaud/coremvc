// Définition du composant "cookies-consent"
export default (app) => {
    app.component('cookies-consent', {
        template: `<div v-if="showBanner" class="cookie-banner bg-light p-3 fixed-bottom shadow-top">
        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0">
                ${window.vueDatas.ccl.cookies_consent_text}
            </p>
            <div>
                <button class="btn btn-link btn-sm" @click="showPreferences = true">${window.vueDatas.ccl.customize}</button>
                <button class="btn btn-primary btn-sm me-2" @click="acceptCookies">${window.vueDatas.ccl.accept}</button>
                <button class="btn btn-secondary btn-sm" @click="declineCookies">${window.vueDatas.ccl.denied}</button>
            </div>
        </div>
        <div v-if="showPreferences" class="cookie-preferences mt-3 p-3 border rounded bg-white">
        <h5>${window.vueDatas.ccl.cookies_consent_preferences}</h5>
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
        <button class="btn btn-success btn-sm mt-3" @click="savePreferences">${window.vueDatas.ccl.choices_record}</button>
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
                essential: window.vueDatas.ccl.cookies_essential,
                analytics: window.vueDatas.ccl.cookies_analytics,
                ads: window.vueDatas.ccl.cookies_ads
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