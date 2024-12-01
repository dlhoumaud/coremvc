# Documentation des Modèles

Les modèles permettent de gérer l'interaction avec la base de données en utilisant une approche orientée objet. Le système repose sur deux classes principales : **`Database`** pour la gestion des connexions à la base de données et **`Model`** pour fournir des fonctionnalités génériques pour les requêtes. Les modèles spécifiques héritent de la classe **`Model`** pour gérer des entités spécifiques (ex. : `User`).

---

## 1. **Classe `Database`**

### **Description**
La classe `Database` fournit une connexion sécurisée à la base de données en utilisant PDO et les variables d'environnement pour configurer les informations de connexion.

### **Code source**
```php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    protected $pdo;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $dbname = !empty(getenv('DB_NAME')) ? ";dbname=".getenv('DB_NAME') : '';
        $charset = !empty(getenv('DB_NAME')) ? ";charset=".getenv('DB_CHARSET') : '';
        $user = getenv('DB_USER');
        $password = getenv('DB_PASS');

        $dsn = "mysql:host=$host$dbname;port=$port$charset";
        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
```

### **Fonctionnalités principales**
- **Connexion sécurisée** : Utilise PDO pour se connecter à MySQL avec les paramètres fournis via des variables d'environnement.
- **Gestion des erreurs** : Capture et gère les erreurs de connexion.
- **Accès à PDO** : Méthode `getConnection()` pour récupérer la connexion PDO.

---

## 2. **Classe `Model`**

### **Description**
La classe `Model` étend `Database` et fournit des outils pour construire et exécuter des requêtes SQL de manière dynamique et fluide (style "Query Builder").

### **Fonctionnalités principales**

#### **Initialisation**
- Définit une table par défaut grâce à l’attribut `protected $table`.
- Initialise les clauses SQL pour chaque requête (SELECT, WHERE, JOINS, etc.).

#### **Requêtes**
1. **SELECT**
   ```php
   $model->select('id, name')->get();
   ```
   Définit les colonnes à sélectionner.

2. **WHERE et conditions complexes**
   - Ajouter des filtres simples :
     ```php
     $model->where('id', '=', 1)->get();
     ```
   - Groupes de conditions :
     ```php
     $model->whereGroup(function($query) {
         $query->where('status', '=', 'active')
               ->or('status', '=', 'pending');
     })->get();
     ```

3. **JOIN**
   ```php
   $model->join('roles', 'users.role_id = roles.id')
         ->get();
   ```
   Ajoute des jointures INNER ou LEFT.

4. **COUNT**
   ```php
   $model->count();
   ```
   Compte le nombre d'éléments correspondant aux critères.

5. **INSERT/UPDATE/DELETE**
   - Mise à jour :
     ```php
     $model->update(['name' => 'John', 'email' => 'john@example.com']);
     ```
   - Suppression :
     ```php
     $model->where('id', '=', 1)->delete();
     ```

#### **Gestion interne**
- **Réinitialisation automatique** : Après exécution, les paramètres sont réinitialisés (`reset()`).
- **Requêtes sécurisées** : Les paramètres sont protégés contre les injections SQL.

---

## 3. **Exemple : Classe `User`**

### **Description**
La classe `User` est un modèle spécifique qui hérite de `Model` pour interagir avec la table `users`.

### **Code source**
```php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';

    public function getAllUsers()
    {
        return $this->get();
    }

    public function getUser($id)
    {
        return $this->where('id', '=', $id)->get(0);
    }

    public function deleteUser($id)
    {
        return $this->where('id', '=', $id)->delete();
    }
}
```

### **Fonctionnalités**
- **`getAllUsers()`** : Récupère tous les utilisateurs.
- **`getUser($id)`** : Récupère un utilisateur spécifique par son `id`.
- **`deleteUser($id)`** : Supprime un utilisateur par son `id`.

### **Exemple d'utilisation**
```php
$userModel = new User();

// Récupérer tous les utilisateurs
$users = $userModel->getAllUsers();

// Récupérer un utilisateur par son ID
$user = $userModel->getUser(1);

// Supprimer un utilisateur
$isDeleted = $userModel->deleteUser(1);
```

---

## 4. **Résumé des Avantages**
- **Réutilisation** : Les fonctionnalités communes sont centralisées dans `Model`.
- **Sécurité** : Utilisation de PDO et des requêtes préparées pour éviter les injections SQL.
- **Flexibilité** : Système de construction de requêtes fluide pour gérer des besoins complexes.
- **Simplicité** : Les modèles spécifiques (comme `User`) sont simples à écrire et étendre.


## 5. **Contexte pour `hasMany()` : Un utilisateur a plusieurs articles (Blog)**

Imaginons que vous ayez deux entités dans une application de blog : **User** (utilisateur) et **Post** (article). Chaque utilisateur peut créer plusieurs articles, mais chaque article appartient à un seul utilisateur. 

- La relation entre **User** et **Post** est **"Un utilisateur a plusieurs articles"**, ce qui correspond à une relation de type `hasMany()`.

### Exemples :
- **Modèle `User`** (un utilisateur peut avoir plusieurs articles) :
    ```php
    $user = new User();
    // Récupérer tous les articles écrits par cet utilisateur
    $posts = $user->hasMany('Post', 'user_id'); // 'user_id' est la clé étrangère dans la table `Post`
    ```

- **Modèle `Post`** (chaque article appartient à un utilisateur) :
    ```php
    $post = new Post();
    // Récupérer l'utilisateur qui a écrit cet article
    $user = $post->belongsTo('User', 'user_id'); // 'user_id' est la clé étrangère dans la table `Post`
    ```

### Explication :
- `hasMany('Post', 'user_id')` dans le modèle **User** récupère tous les **Post** associés à un utilisateur particulier (via `user_id` dans la table `Post`).
- `belongsTo('User', 'user_id')` dans le modèle **Post** récupère l'**User** auquel appartient cet **Post** via la clé étrangère `user_id` dans la table `Post`.

## 6. **Contexte pour `hasMany()` et `belongsTo()` : Une commande a plusieurs produits**

Imaginons un autre scénario avec deux entités dans un système de commande : **Order** (commande) et **Product** (produit). 

- Une **commande** peut avoir plusieurs produits.
- Chaque **produit** appartient à une **commande** spécifique.

Dans ce cas, il y a une relation **"Une commande a plusieurs produits"** et **"Un produit appartient à une commande"**.

### Exemples :
- **Modèle `Order`** (une commande peut avoir plusieurs produits) :
    ```php
    $order = new Order();
    // Récupérer tous les produits associés à cette commande
    $products = $order->hasMany('Product', 'order_id'); // 'order_id' est la clé étrangère dans la table `Product`
    ```

- **Modèle `Product`** (chaque produit appartient à une commande) :
    ```php
    $product = new Product();
    // Récupérer la commande à laquelle ce produit appartient
    $order = $product->belongsTo('Order', 'order_id'); // 'order_id' est la clé étrangère dans la table `Product`
    ```

### Explication :
- `hasMany('Product', 'order_id')` dans le modèle **Order** récupère tous les **Product** associés à une commande particulière (via `order_id` dans la table `Product`).
- `belongsTo('Order', 'order_id')` dans le modèle **Product** récupère l'**Order** auquel appartient ce **Product** via la clé étrangère `order_id` dans la table `Product`.

## Résumé des Relations :
- **`hasMany()`** : Utilisé dans le modèle "un" d'une relation "un à plusieurs". Exemple : **Un utilisateur a plusieurs articles**.
- **`belongsTo()`** : Utilisé dans le modèle "plusieurs" d'une relation "un à plusieurs". Exemple : **Un article appartient à un utilisateur**.

## Conclusion :
- **`hasMany()`** est pour le côté "un" de la relation (ex. : Un utilisateur a plusieurs articles, une commande a plusieurs produits).
- **`belongsTo()`** est pour le côté "plusieurs" de la relation (ex. : Un article appartient à un utilisateur, un produit appartient à une commande).