<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-11 15:54:43
 * @ Description: Script de fonctionnalités globales
 */

 /**
  * Charge les variables d'environnement à partir d'un fichier .env, en cachant le résultat pour améliorer les performances.
  *
  * Si le fichier .env a été modifié depuis la dernière génération du fichier de cache, le cache est invalidé
  * Et les variables d'environnement sont rechargées à partir du fichier .env.
  *
  * @param string $envPath   The path to the .env file.
  * @param string $cachePath The path to the cache file.
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
 * Injecte le contenu d'un fichier PHP et renvoie la sortie.
 *
 * @param string $filename The path to the PHP file to include.
 * @param array $data An optional array of data to extract and make available in the included file.
 * @return string The output of the included file.
 */
function inject($filename, $data=[]): string
{
    if (!file_exists($filename)) return '';
    if (!empty($data)) extract($data); // Récupère les données à injecter
    ob_start(); // Démarre la capture de sortie
    include $filename; // Inclut et exécute le fichier
    return ob_get_clean(); // Capture et nettoie le tampon
}

/**
 * Injecte le contenu d'un fichier JS et renvoie la sortie.
 *
 * @param string $filename The path to the JS file to include.
 * @param array $data An optional array of data to extract and make available in the included file.
 * @return string The output of the included file.
 */
function injectJS($filename, $data=[]): string
{
    if (!file_exists($filename)) return '';
    $content = ''; 
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $value = json_encode($value);
        } else if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        } else if (is_null($value)) {
            $value = 'null';
        } else if (is_numeric($value)) {
            $value = $value;
        } else {
            $value = "'".str_replace("'", "\'", $value)."'";
        }
        $content .= "const $key = $value;\n";
    }
    $content .= file_get_contents($filename);
    return $content; 
}

/**
 * Injecte le contenu d'un fichier PHP et renvoie la sortie.
 *
 * @param string $filename The path to the PHP file to include.
 * @param array $data An optional array of data to extract and make available in the included file.
 * @return string The output of the included file.
 */
function view($filename, $data=[]): string {
    if (file_exists($filename)) {
        return inject('../app/views/'.$filename, $data);
    } else if (file_exists('../app/views/'.$filename)) {
        return inject('../app/views/'.$filename, $data);
    } else if (file_exists('../app/views/'.$filename.'.php')) {
        return inject('../app/views/'.$filename.'.php', $data);
    }
    return '';
}


/**
 * Récupère le texte localisé pour la clé donnée.
 *
 * @param string $text La clé du texte localisé à récupérer.
 * @return string Le texte localisé ou le texte d'origine si aucune localisation n'est disponible.
 */
function l($text) {
    return ($_SESSION['lang_controller'][$text] ?? ($_SESSION['lang_global'][$text] ?? $text));
}

function __($text) { 
     return l($text); 
}