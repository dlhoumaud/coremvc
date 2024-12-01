# Système de Routage

## Fonctionnalités Principales
1. **Chargement des routes** : Les routes sont définies dans un fichier `config/routes.json`.
2. **Cache des routes** : Un fichier de cache est généré dans `storage/cache/routes.php` pour optimiser les performances.
3. **Support des routes dynamiques** : Les routes avec paramètres (par exemple, `/user/{id}`) sont supportées grâce à des expressions régulières.
4. **Gestion des erreurs** : Les routes non trouvées déclenchent une action `e404` du contrôleur `ErrorController`.

---

## Définition des Routes
Les routes sont déclarées dans le fichier JSON `config/routes.json`. Chaque route spécifie un contrôleur et une action à appeler. Exemple :  
```json
{
    "/login": {
        "controller": "UserController",
        "action": "login"
    }
}
```

## Structure des Routes
- **URI statiques** : Correspondance directe avec les URI définies, par exemple `/login`.
- **URI dynamiques** : Permettent de définir des paramètres dans les URI, par exemple `/user/{id}`.

---

## Cache des Routes
Pour accélérer le chargement des routes :  
1. **Vérification** : Le système vérifie si le fichier de cache `routes.php` est à jour en comparant les dates de modification.  
2. **Génération** : Si nécessaire, le fichier est généré en convertissant le JSON en tableau PHP.

---

## Processus de Distribution
Lorsqu'une requête est reçue :  
1. **Vérification des URI statiques** : Si l'URI correspond à une route statique, le contrôleur et l'action sont appelés directement.  
2. **Vérification des URI dynamiques** : Si une route contient des paramètres, le système utilise des expressions régulières pour faire correspondre l'URI et extraire les paramètres.  
3. **Gestion des erreurs** : Si aucune route ne correspond, une erreur 404 est levée via `ErrorController::e404()`.

---

## Exemple de Routage Dynamique
Route définie :  
```json
"/user/{id}": {
    "controller": "UserController",
    "action": "show"
}
```

Requête reçue : `/user/42`  
1. La route est analysée pour détecter `{id}`.  
2. Le paramètre `id` est extrait de l'URI.  
3. Le contrôleur `UserController` est instancié, et l'action `show` est appelée avec `id=42`.

---

## Fonctionnement de la Mise en Cache des Routes

Le système de mise en cache des routes dans CroreMVC est conçu pour optimiser les performances en évitant de recharger et de parser le fichier `routes.json` à chaque requête. Voici une explication détaillée de son fonctionnement :

1. **Chargement des Routes** :
   - Les routes sont définies dans le fichier `config/routes.json`, qui utilise le format JSON.
   - Lorsque le routeur est instancié, il vérifie si un fichier de cache des routes existe dans `storage/cache/routes.php`.

2. **Vérification de l'Actualité du Cache** :
   - Le framework compare la date de modification du fichier JSON (`routes.json`) avec celle du fichier de cache (`routes.php`).
   - Si le fichier de cache est **plus récent** que le fichier JSON, il est considéré comme valide et utilisé directement.
   - Si le fichier JSON a été modifié depuis la dernière génération du cache, le fichier de cache est recréé.

3. **Génération du Fichier de Cache** :
   - Si nécessaire, le framework charge les routes depuis le fichier JSON et les transforme en un tableau PHP.
   - Le tableau PHP est ensuite exporté dans un fichier `routes.php` en utilisant la fonction `var_export`.
   - Ce fichier est écrit dans le répertoire `storage/cache/`.

   Exemple de contenu généré dans `routes.php` :
   ```php
   <?php return [
       "/" => [
           "controller" => "HomeController",
           "action" => "index"
       ],
       "/login" => [
           "controller" => "UserController",
           "action" => "login"
       ]
   ];
   ```

4. **Utilisation du Cache** :
   - Si le cache est valide, le tableau des routes est inclus directement via `include`.
   - Cette méthode est plus rapide que la lecture et le décodage du fichier JSON, car le fichier PHP est déjà parsé par le serveur.

---

## Code Relatif au Système de Cache

- **Vérification et Chargement** :
  ```php
  if (file_exists($cacheFile) && filemtime($cacheFile) >= filemtime($jsonFile)) {
      $this->routes = include $cacheFile;
  } else {
      $this->routes = json_decode(file_get_contents($jsonFile), true);
      $this->generateCache($cacheFile);
  }
  ```

- **Génération du Fichier de Cache** :
  ```php
  private function generateCache($cacheFile)
  {
      $content = '<?php return ' . var_export($this->routes, true) . ';';
      file_put_contents($cacheFile, $content);
  }
  ```

---

## Avantages de la Mise en Cache
- **Performance** : Réduction du temps de chargement des routes en évitant de parser un fichier JSON à chaque requête.
- **Facilité de Mise à Jour** : Le cache est automatiquement recréé si `routes.json` est modifié.
- **Compatibilité** : Le fichier de cache est en format PHP natif, parfaitement adapté à un serveur web.

---

## Points d'Attention
- Assurez-vous que le répertoire `storage/cache/` est accessible en écriture par le serveur.
- Si le cache devient obsolète ou corrompu, il suffit de supprimer manuellement le fichier `routes.php` pour forcer sa régénération.