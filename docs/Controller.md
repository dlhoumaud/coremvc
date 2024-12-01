# Documentation des Contrôleurs dans **CroreMVC**

Les contrôleurs dans **CroreMVC** sont responsables de gérer les requêtes HTTP, de préparer les données nécessaires à la vue, et de renvoyer la réponse au client. Ils héritent de la classe `App\Core\Controller`, qui fournit des méthodes utilitaires comme le rendu des vues.

---

## **Structure et Fonctionnement des Contrôleurs**

1. **Héritage de la Classe de Base**
   Tous les contrôleurs doivent étendre la classe `App\Core\Controller` pour bénéficier des fonctionnalités de base, telles que le rendu des vues.

   Exemple :
   ```php
   namespace App\Controllers;

   use App\Core\Controller;

   class HomeController extends Controller
   {
       // Actions définies ici
   }
   ```

2. **Organisation des Actions**
   Les actions sont des méthodes publiques au sein des contrôleurs, chacune correspondant à une route définie dans le fichier `config/routes.json`. Ces actions :
   - Préparent les données nécessaires pour la vue.
   - Appellent la méthode `view` pour afficher une page spécifique.

   Exemple d'action dans le `HomeController` :
   ```php
   public function index()
   {
       $data = [
           'head_title' => 'Bienvenue sur CoreMVC'
       ];
       self::view('home', $data);
   }
   ```

3. **Utilisation des Données**
   Les données à transmettre à une vue sont préparées sous forme de tableau associatif, puis passées en paramètre à la méthode `view`.

---

## **Classe de Base : `App\Core\Controller`**

### Méthode : `view`

- **Prototype** :
  ```php
  static protected function view($view, $data = []);
  ```

- **Paramètres** :
  - `$view` : Nom du fichier de la vue (sans extension `.php`), situé dans le répertoire `app/views/`.
  - `$data` : Tableau associatif contenant les données à passer à la vue.

- **Description** :
  La méthode `view` :
  1. Extrait les données du tableau `$data` pour les rendre disponibles sous forme de variables dans la vue.
  2. Charge successivement les fichiers suivants (si présents) :
     - `head.php` (dans `app/views/core`) : Contient les métadonnées HTML et les inclusions CSS/JS.
     - `header.php` (dans `app/views/layout`) : Entête de la page.
     - Vue principale (`$view.php`) : Le contenu principal de la page.
     - `footer.php` (dans `app/views/layout`) : Pied de page.
     - `end.php` (dans `app/views/core`) : Scripts ou balises de fermeture spécifiques.

   Exemple de flux de chargement pour une vue `home` :
   - `app/views/core/head.php`
   - `app/views/layout/header.php`
   - `app/views/home.php`
   - `app/views/layout/footer.php`
   - `app/views/core/end.php`

- **Exemple d'Appel** :
  ```php
  $data = ['head_title' => 'Bienvenue', 'content' => 'Hello World!'];
  self::view('home', $data);
  ```

---

## **Exemple de Contrôleur : `HomeController`**

Le `HomeController` gère les actions associées à la page d'accueil et à la page "À propos".

- **Action `index`** :
  - Prépare les données pour la page d'accueil, telles que le titre de la page (`head_title`) et des composants Vue.js dynamiques.
  - Charge la vue `home`.

  ```php
  public function index()
  {
      $data = [
          'head_title' => 'Bienvenue sur CoreMVC',
          'vue_components' => HomeService::getVueComponents()
      ];
      self::view('home', $data);
  }
  ```

- **Action `about`** :
  - Prépare les données pour la page "À propos".
  - Charge la vue `about`.

  ```php
  public function about()
  {
      $data = ['head_title' => 'À propos de CoreMVC'];
      self::view('about', $data);
  }
  ```

---

## **Convention de Nommage des Contrôleurs**

1. Les noms des contrôleurs doivent suivre le format **PascalCase** avec le suffixe `Controller`.
   Exemple : `HomeController`, `UserController`.

2. Les contrôleurs sont définis dans le namespace `App\Controllers`.

---

## **Chargement Automatique des Contrôleurs**

Les contrôleurs sont chargés automatiquement via le système de routage défini dans `Router.php`. Chaque route associe un chemin URI à un contrôleur et une action. Par exemple :

- Route `/` :
  ```json
  {
      "controller": "HomeController",
      "action": "index"
  }
  ```

- Processus :
  1. Le routeur identifie `HomeController` comme contrôleur et `index` comme méthode.
  2. Le contrôleur est instancié et la méthode est appelée :
     ```php
     $controller = new App\Controllers\HomeController();
     $controller->index();
     ```

---

## **Résumé**

Les contrôleurs dans **CroreMVC** jouent un rôle central en :
- Organisant la logique de traitement des requêtes.
- Préparant les données pour les vues.
- Rendant les pages web via la méthode `view`.