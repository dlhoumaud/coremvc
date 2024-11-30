# Documentation : Utilisation de Vue.js dans les Vues de CoreMVC

## Introduction

CoreMVC intègre Vue.js pour gérer l'interactivité côté client dans ton application web. Cette documentation te guide sur la façon de configurer et d'utiliser Vue.js avec CoreMVC pour une meilleure gestion de l'interface utilisateur.  
Cette documentation explique comment intégrer et utiliser **Vue.js** dans le framework **CoreMVC** pour créer des interfaces utilisateur dynamiques et interactives. Elle détaille les fichiers clés, la configuration, et la manière de structurer les composants Vue.js au sein du framework.

---

## Configuration Générale

### Structure des Fichiers
Votre projet suit une structure claire où Vue.js est intégré au sein du répertoire `public/js`. Voici un aperçu des fichiers concernés :

- **`public/js/app.js`** : Point d'entrée principal de l'application Vue.js.
- **`public/js/components/`** : Répertoire contenant les composants Vue.js réutilisables.
- **`app/controllers/`** : Les contrôleurs PHP définissant les données et les composants à charger.
- **`app/services/`** : Les services pour centraliser les appels logiques et injecter des scripts Vue.js.

---

### Initialisation de Vue.js
Dans **`public/js/app.js`**, Vue.js est configuré pour récupérer dynamiquement des données et des méthodes passées par PHP. 

Voici une documentation détaillée expliquant comment utiliser Vue.js avec ton framework CoreMVC. Cette documentation couvre l'installation, la configuration, la gestion des composants Vue, ainsi que la manière de les charger dynamiquement dans les vues de ton application.

---


### **Prérequis**

Avant de commencer, assure-toi que les éléments suivants sont en place :

- **PHP 7.4+** (ou supérieur) pour le backend.
- **Vue.js** (version 3.x ou plus récente) doit être installé et configuré sur ton projet.
- Ton projet doit suivre la structure de base de CoreMVC, avec des vues PHP et un répertoire `public/js` où seront placés tes composants Vue.js.

---

### **Étapes pour intégrer Vue.js avec CoreMVC**


#### **1. Configuration du Backend (CoreMVC)**

Ton backend est responsable de fournir les composants Vue à l'application. Dans le contrôleur, tu définis les composants nécessaires pour chaque page.

##### Exemple de contrôleur : `HomeController.php`

```php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Session;
use App\Services\HomeService;

class HomeController extends Controller
{
    public function index()
    {
        // Initialisation du titre de la page dans la session
        Session::set('title', 'Bienvenue sur CoreMVC');
        
        // Données à envoyer à la vue
        $data = [
            'head_title' => Session::get('title'),  // Titre à afficher dans le <head>
            'vue_components' => HomeService::getVueComponents()  // Liste des composants Vue à charger
        ];

        // Charger la vue 'home' avec les données
        self::view('home', $data);
    }

    public function about()
    {
        Session::set('title', 'À propos de CoreMVC');
        $data = ['head_title' => Session::get('title')];
        self::view('about', $data);
    }
}
```

- **Session** : Utilise `Session::set()` pour stocker des informations côté serveur, comme le titre de la page.
- **HomeService** : Le service récupère la liste des composants Vue.js nécessaires pour chaque page (ex. `carousel/indicators.min`, `hello-coremvc.min`).

##### Exemple de service : `HomeService.php`

```php
namespace App\Services;

class HomeService
{
    static public function getVueComponents() {
        // Liste des composants Vue.js à charger pour la page
        return [
            'carousel/indicators.min',
            'carousel/item.min',
            'card/img-top.min',
            'hello-coremvc.min',
        ];
    }
}
```

- **getVueComponents()** : Retourne un tableau avec les noms de fichiers des composants Vue.js. Ces composants seront chargés côté client.

---

#### **2. Configuration de l'Application Vue.js**

Dans ton fichier JavaScript (par exemple `app.js`), tu initialises Vue.js et tu charges les composants de manière dynamique.

##### Exemple de fichier `app.js`

```javascript
// Initialiser l'application Vue.js
const app = Vue.createApp({
    data() {
        return window.vueDatas;  // Données dynamiques passées par PHP
    },
    methods: window.vueMethods,  // Méthodes dynamiques passées par PHP
});

// Ajouter un composant supplémentaire si nécessaire
window.vueComponents.push('cookies-consent.min');

// Charger tous les composants de manière asynchrone
const loadComponents = window.vueComponents.map(component => 
    import(`/js/components/${component}.js`)
        .then(module => {
            if (module.default) {
                module.default(app);  // Enregistrer le composant dans l'application Vue
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
        // Monter l'application Vue dans l'élément HTML avec id="app"
        app.mount('#app');
    })
    .catch(err => {
        console.error('Erreur lors du chargement des composants:', err);
    });
```

##### Explication des éléments clés :

- **`Vue.createApp({...})`** : Crée une nouvelle instance de Vue avec les données et méthodes extraites de `window.vueDatas` et `window.vueMethods`. Ces données et méthodes sont injectées depuis le backend PHP.
  
- **`window.vueComponents.push('cookies-consent.min')`** : Cette ligne permet d'ajouter des composants Vue dynamiquement (par exemple, un composant de consentement de cookies).

- **Chargement dynamique des composants** : 
  Utilise la fonction `import()` pour charger les composants de manière asynchrone. Cela permet de ne charger que les composants nécessaires, optimisant ainsi les performances.

- **`Promise.all(loadComponents)`** : Garantit que tous les composants sont chargés avant de monter l'application Vue dans l'élément avec l'ID `#app`.

---

#### **3. Utilisation des Composants Vue.js**

Les composants Vue.js sont des fichiers JavaScript (par exemple, `carousel/indicators.min.js`) qui contiennent des logiques spécifiques. Ces fichiers sont ensuite importés et ajoutés à l'instance Vue au moment de son initialisation.

##### Exemple de composant Vue : `carousel/indicators.min.js`

```javascript
export default function(app) {
    app.component('carousel-indicators', {
        template: `<div class="carousel-indicators">[Carousel Indicators]</div>`,
        data() {
            return {
                // Données du composant
            };
        },
        methods: {
            // Méthodes du composant
        },
    });
}
```

- **Déclaration du composant** : Utilise `app.component()` pour enregistrer un composant Vue dans l'application.
- **Template** : Contient le HTML du composant, ici un indicateur de carousel.
- **Data et Methods** : Définis les données et méthodes nécessaires à la logique du composant.

---

### **Conclusion**

L'intégration de Vue.js avec CoreMVC permet de gérer de manière fluide l'interactivité côté client tout en gardant un backend PHP léger et modulaire. Grâce au système de chargement dynamique des composants, tu optimises les performances de l'application en ne chargeant que les composants nécessaires.

