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

## Gestion des erreurs
Le script vérifie la validité des options passées en argument et renvoie des messages d'erreur en cas de problème, par exemple si un fichier n'existe pas pour les opérations de chiffrement ou déchiffrement, ou si le répertoire `./public` est manquant lors du lancement du serveur.

## Dépendances
Le script utilise les classes suivantes :
- **Autoloader** : Pour autoloading des classes de l'application.
- **Router** : Bien que non utilisé directement dans ce script, il fait partie du projet global.
- **Database** : Utilisée pour exécuter les migrations et seeders.

## Conclusion
Le script `bin/morty.php` est un outil de développement pratique pour automatiser certaines tâches courantes, telles que le lancement du serveur PHP, le chiffrement/déchiffrement de fichiers, et la gestion des migrations et seeders pour la base de données. Il offre une interface simple en ligne de commande pour interagir avec ces fonctionnalités.

