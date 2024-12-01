# Documentation du script **bin/morty.php**

## Introduction
Le script `bin/morty.php` est un outil de développement destiné à faciliter certaines tâches courantes telles que le lancement d'un serveur de développement PHP, le chiffrement et le déchiffrement de fichiers, ainsi que l'exécution des migrations et seeders pour une base de données. Il fait partie d'un projet utilisant le design pattern MVC en PHP.

## Structure du script
Le script se situe dans le répertoire `bin/` et dépend de plusieurs composants clés de l'application, tels que l'autoloader, le routeur et la gestion de la base de données. Il utilise également un fichier de configuration (`config/config.php`) et charge les variables d'environnement via un cache.

## Fonctionnalités principales

### 1. **Lancer un serveur PHP**
L'option `-s` ou `--server` permet de lancer un serveur de développement PHP sur l'adresse et le port spécifiés. Le serveur sert le contenu du répertoire `./public` de l'application.

#### Syntaxe
```bash
php bin/morty.php -s [adresse:port] 
```

- **`[adresse:port]`** : Spécifiez l'adresse et le port du serveur (par défaut `localhost:8000`).

#### Exemple d'utilisation
```bash
php bin/morty.php -s localhost:8080
```

### 2. **Chiffrement d'un fichier**
L'option `-e` ou `--encrypt` permet de chiffrer un fichier spécifié.

#### Syntaxe
```bash
php bin/morty.php -e [fichier] -k [clé]
```

- **`[fichier]`** : Spécifiez le fichier à chiffrer.
- **`[clé]`** : (Optionnel) Spécifiez une clé de chiffrement personnalisée.

#### Exemple d'utilisation
```bash
php bin/morty.php -e mon_fichier.txt -k ma_clé_secrète
```

### 3. **Déchiffrement d'un fichier**
L'option `-d` ou `--decrypt` permet de déchiffrer un fichier spécifié.

#### Syntaxe
```bash
php bin/morty.php -d [fichier] -k [clé]
```

- **`[fichier]`** : Spécifiez le fichier à déchiffrer.
- **`[clé]`** : (Optionnel) Spécifiez la clé de chiffrement pour le déchiffrement.

#### Exemple d'utilisation
```bash
php bin/morty.php -d mon_fichier_chiffre.txt -k ma_clé_secrète
```

### 4. **Exécution des migrations**
L'option `-M` ou `--migrate` permet d'exécuter les migrations de base de données.

#### Syntaxe
```bash
php bin/morty.php -M [up|down|create]
```

- **`[up]`** : Applique la migration (création des tables).
- **`[down]`** : Annule la migration (suppression des tables).
- **`[create]`** : Crée un fichier de migration vide.

#### Exemple d'utilisation
```bash
php bin/morty.php -M up
```

### 5. **Exécution des seeders**
L'option `-S` ou `--seed` permet d'exécuter les seeders de base de données.

#### Syntaxe
```bash
php bin/morty.php -S [up|down|create]
```

- **`[up]`** : Exécute les seeders pour insérer des données dans la base.
- **`[down]`** : Exécute les seeders pour supprimer des données.
- **`[create]`** : Crée un fichier de seeder vide.

#### Exemple d'utilisation
```bash
php bin/morty.php -S up
```

### 6. **Affichage de l'aide**
L'option `-h` ou `--help` affiche un message d'aide détaillé sur les options disponibles.

#### Syntaxe
```bash
php bin/morty.php -h
```

### Exemples complets
- Lancer un serveur PHP sur `localhost:8080` :
    ```bash
    php bin/morty.php -s localhost:8080
    ```
- Chiffrer un fichier `.env` avec la clé `secret_key` :
    ```bash
    php bin/morty.php -e .env -k secret_key
    ```
- Appliquer une migration pour créer une table :
    ```bash
    php bin/morty.php -M up
    ```
- Exécuter un seeder pour insérer des données :
    ```bash
    php bin/morty.php -S up
    ```

### Création de classes PHP

Le script permet de créer des fichiers de classes PHP via une interface en ligne de commande (CLI). Les options passées en paramètre déterminent le type et le nom de la classe à générer.

---

#### **Options Disponibles**
- `-c` ou `--create` : Spécifie le type de classe à créer (par exemple, `controller`, `model`, `service`).
- `-n` ou `--name` : Spécifie le nom de la classe.

> **Remarque :** Vous pouvez utiliser les versions courtes (`-c` et `-n`) ou longues (`--create` et `--name`) des options. Elles sont interchangeables.

---

#### **Commandes Pratiques**

1. **Créer un contrôleur :**

```bash
php script.php -c controller -n Article
# ou
php script.php --create=controller --name=Article
```

**Résultat attendu :**
- Un fichier `ArticleController.php` sera généré dans le répertoire `app/controllers/`.
- Contenu du fichier :
  ```php
  <?php
  /**
   * @ Author: 
   * @ Create Time: 2024-12-01 14:30:00
   * @ Modified by: 
   * @ Modified time: 2024-12-01 14:30:00
   * @ Description: 
   */
  namespace App\Controllers;

  use App\Core\Controller;

  class ArticleController extends Controller
  {
      public function show()
      {
          $data = [
              'head_title' => 'Title de la page',
              'head_description' => 'Description de la page',
              'head_keywords' => 'Mots-clés de la page',
              'head_author' => 'Auteur de la page',
              'head_viewport' => '',
              'main_attributes' => '',
              'vue_datas' => [],
              'vue_methods' => [],
              'vue_components' => [],
          ];
          self::view('article', $data);
      }
  }
  ```

---

2. **Créer un modèle :**

```bash
php script.php -c model -n User
# ou
php script.php --create=model --name=User
```

**Résultat attendu :**
- Un fichier `User.php` sera généré dans le répertoire `app/models/`.
- Contenu du fichier :
  ```php
  <?php
  /**
   * @ Author: 
   * @ Create Time: 2024-12-01 14:30:00
   * @ Modified by: 
   * @ Modified time: 2024-12-01 14:30:00
   * @ Description: 
   */
  use App\Core\Model;

  class User extends Model
  {
    protected $table = 'user';
  }
  ```

---

3. **Créer un service :**

```bash
php script.php -c service -n Email
# ou
php script.php --create=service --name=Email
```

**Résultat attendu :**
- Un fichier `EmailService.php` sera généré dans le répertoire `app/services/`.
- Contenu du fichier :
  ```php
  <?php
  /**
   * @ Author: 
   * @ Create Time: 2024-12-01 14:30:00
   * @ Modified by: 
   * @ Modified time: 2024-12-01 14:30:00
   * @ Description: 
   */
  namespace App\Services;

  class EmailService
  {
      public function __construct()
      {
          /// Initialisation du service
      }
  }
  ```

---

#### **Cas d'Erreur**
- Si le type spécifié (`controller`, `model`, ou `service`) n'est pas reconnu :

```bash
php script.php -c invalidType -n Name
```

**Message d'erreur :**
```
Type de classe non valide.
```

- Si une option requise manque (par exemple, `--name` ou `--create`) :

```bash
php script.php -c controller
```

**Aucun fichier ne sera créé.**

---

#### **Résumé des Étapes :**

1. Passer les options nécessaires (`-c`/`--create` et `-n`/`--name`).
2. Le script identifie le type de classe à créer.
3. Une fonction associée génère un fichier avec la structure pré-remplie.
4. Les fichiers sont sauvegardés dans les répertoires appropriés :
   - `app/controllers/`
   - `app/models/`
   - `app/services/`

## Gestion des erreurs
Le script vérifie la validité des options passées en argument et renvoie des messages d'erreur en cas de problème, par exemple si un fichier n'existe pas pour les opérations de chiffrement ou déchiffrement, ou si le répertoire `./public` est manquant lors du lancement du serveur.

## Dépendances
Le script utilise les classes suivantes :
- **Autoloader** : Pour autoloading des classes de l'application.
- **Router** : Bien que non utilisé directement dans ce script, il fait partie du projet global.
- **Database** : Utilisée pour exécuter les migrations et seeders.

## Conclusion
Le script `bin/morty.php` est un outil de développement pratique pour automatiser certaines tâches courantes, telles que le lancement du serveur PHP, le chiffrement/déchiffrement de fichiers, et la gestion des migrations et seeders pour la base de données. Il offre une interface simple en ligne de commande pour interagir avec ces fonctionnalités.

