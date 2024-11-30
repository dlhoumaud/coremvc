<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-30 16:01:36
 * @ Description: Script de fonctionnalités
 */

 function loadEnvWithCache($envPath, $cachePath)
 {
    // Si le cache est périmé ou n'existe pas, charger depuis le fichier .env
    if (!file_exists($envPath)) {
        throw new Exception('Le fichier .env est introuvable à l\'emplacement spécifié : ' . $envPath);
    }
    
     // Vérifier si le fichier de cache existe et s'il est valide (pas trop vieux)
     if (file_exists($cachePath) && filemtime($cachePath) >= filemtime($envPath)) {
         // Charger les variables depuis le fichier de cache
         $cachedEnv = include $cachePath;
         foreach ($cachedEnv as $key => $value) {
             putenv("$key=$value");
             $_ENV[$key] = $value;  // Optionnel, mais permet d'utiliser $_ENV aussi
         }
         return;
     }
 
     // Lire le fichier .env ligne par ligne
     $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
     $envVars = [];
 
     foreach ($lines as $line) {
         // Ignorer les commentaires (lignes commençant par # ou ;)
         if (strpos($line, '#') === 0 || strpos($line, ';') === 0) {
             continue;
         }
 
         // Séparer les clés et les valeurs sur le signe "="
         $parts = explode('=', $line, 2);
 
         if (count($parts) == 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]).($key=='VERSION'?'.'.time():'');

            // Définir la variable d'environnement
            putenv("$key=$value");
            $_ENV[$key] = $value;  // Optionnel
            $envVars[$key] = $value;  // Conserver dans un tableau pour générer le cache
         }
     }
 
     // Générer le fichier de cache
     file_put_contents($cachePath, '<?php return ' . var_export($envVars, true) . ';');
 }


/**
 * Chiffre le contenu d'un fichier .env et l'enregistre dans un nouveau fichier.
 *
 * @param string $inputFile  Le chemin du fichier .env à chiffrer.
 * @param string $outputFile Le chemin du fichier de sortie chiffré.
 * @param string $key        La clé de chiffrement (doit être de 32 caractères pour AES-256-CBC).
 * @return void
 */
function encryptFile($inputFile, $outputFile, $key)
{
    // Lecture du contenu du fichier .env
    $data = file_get_contents($inputFile);

    // Génération d'un vecteur d'initialisation (IV) pour AES-256-CBC
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));

    // Chiffrement des données
    $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);

    if ($encryptedData === false) {
        throw new Exception("Erreur lors du chiffrement des données.");
    }

    // Écriture du IV et des données chiffrées dans le fichier de sortie
    $encryptedFileContent = base64_encode($iv . $encryptedData);
    file_put_contents($outputFile, $encryptedFileContent);
}

/**
 * Déchiffre le contenu d'un fichier chiffré .env et le renvoie sous forme de chaîne de caractères.
 *
 * @param string $inputFile Le chemin du fichier chiffré à déchiffrer.
 * @param string $key       La clé de déchiffrement (doit être de 32 caractères pour AES-256-CBC).
 * @return string           Les données déchiffrées.
 */
function decryptFile($inputFile, $outputFile, $key)
{
    // Lecture du contenu du fichier chiffré
    $encryptedFileContent = file_get_contents($inputFile);
    $encryptedData = base64_decode($encryptedFileContent);

    // Extraction du vecteur d'initialisation (IV) et des données chiffrées
    $ivLength = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($encryptedData, 0, $ivLength);
    $encryptedData = substr($encryptedData, $ivLength);

    // Déchiffrement des données
    $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $key, 0, $iv);

    if ($decryptedData === false) {
        throw new Exception("Erreur lors du déchiffrement des données.");
    }

    file_put_contents($outputFile, $decryptedData);
}

/**
 * Exécute une migration en fonction du type spécifié (up ou down).
 *
 * @param Database $db     Instance de la classe Database pour la connexion.
 * @param string $file     Chemin du fichier de migration.
 * @param string $type     Type de migration à exécuter ('up' pour créer, 'down' pour supprimer).
 * @return void
 * @throws Exception       Lance une exception si le type est incorrect ou en cas d'erreur SQL.
 */
function runMigration($db, string $file, string $type = 'up', bool $is_seed = false)
{

    if (file_exists('storage/cache/'.$file) && $type=='up') {
        return;
    }
    
    $type_file = $is_seed ? 'graine' : 'migration';
    // Vérifie que le fichier de migration existe
    if (!file_exists($file)) {
        throw new Exception("Le fichier de $type_file spécifié n'existe pas : {$file}");
    }

    // Charge la migration depuis le fichier
    $migration = include $file;

    // Vérifie que la migration contient les clés 'up' et 'down'
    if (!isset($migration['up']) || !isset($migration['down'])) {
        throw new Exception("Le fichier de $type_file doit contenir les clés 'up' et 'down'.");
    }

    // Sélectionne la requête appropriée selon le type (up ou down)
    $query = $migration[$type] ?? null;
    if ($query === null) {
        throw new Exception("Type de $type_file non valide : {$type}. Utilisez 'up' ou 'down'.");
    }

    // Exécute la requête de migration
    try {
        if (!file_exists('storage/cache/'.$file) && $type=='down') return;
        $pdo = $db->getConnection();
        $pdo->exec($query);
        echo ucfirst($type_file)." '{$type}' de {$file} exécutée avec succès.\n";
        if ($type == 'up') {
            file_put_contents('storage/cache/'.$file, '', FILE_APPEND);
        } else {
            unlink('storage/cache/'.$file);
        }
        if (getEnv('APP_DEBUG')) file_put_contents('storage/logs/database-'.($is_seed?'seed':'migrate').'.log', date("d-m-Y H:i:s")."\t".ucfirst($type_file)." '{$type}' de {$file} exécutée avec succès.\n", FILE_APPEND);
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de l'exécution de la $type_file : " . $e->getMessage());
    }
}

// Fonction pour scanner un dossier et filtrer les fichiers/dossiers spéciaux
function scanDirectory($directory)
{
    // Vérifie si le dossier existe
    if (!is_dir($directory)) {
        throw new Exception("Le dossier spécifié n'existe pas.");
    }

    // Utilise scandir pour obtenir le contenu du dossier
    $files = scandir($directory);

    // Filtre les résultats pour ignorer les entrées spéciales "." et ".."
    $files = array_diff($files, ['.', '..']);

    return $files; // Renvoie le tableau de fichiers/dossiers
}

function inject($filename, $data=[]) {
    if (!file_exists($filename)) return '';
    if (!empty($data)) extract($data); // Récupère les données à injecter
    ob_start(); // Démarre la capture de sortie
    include $filename; // Inclut et exécute le fichier
    return ob_get_clean(); // Capture et nettoie le tampon
}