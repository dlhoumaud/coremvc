<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-11 13:30:08
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

     $envVars['APP_URL']  = (!isset($_ENV['APP_SCHEMA']) || $_ENV['APP_SCHEMA'] ==''?'http://':$_ENV['APP_SCHEMA'].'://')
                            .(!isset($_ENV['APP_HOST']) || $_ENV['APP_HOST']==''?'localhost':$_ENV['APP_HOST'])
                            .(!isset($_ENV['APP_PORT']) || $_ENV['APP_PORT']==''?'':':'.$_ENV['APP_PORT']);
    putenv('APP_URL='.$envVars['APP_URL']);
    $_ENV['APP_URL'] = $envVars['APP_URL'];
 
     // Générer le fichier de cache
     file_put_contents($cachePath, '<?php return ' . var_export($envVars, true) . ';');
 }

/**
 * Creates the necessary cache directory for a file path.
 *
 * @param string $filePath The path to the file for which to create the cache directory.
 */
function createCacheDirectory($filePath) {
    // Extraire le répertoire parent du fichier
    $dir = dirname($filePath); // Cela retourne le chemin du répertoire parent
    
    // Construire le chemin du répertoire de cache correspondant
    $cacheDir = '../storage/cache' . $dir; // Le chemin cible dans cache

    // Créer les répertoires nécessaires de manière récursive
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true); // true permet de créer tous les répertoires parents
    }
}

/**
 * Creates a cache file for a view based on the provided source path.
 *
 * @param string $sourcePath The path to the source file.
 * @return string The path to the cached file.
 */
function createCacheViewFile($sourcePath)
{
    $cPath=str_replace(['../app', '.view'], ['../storage/cache', '.php'], $sourcePath);
    if (file_exists($cPath) && filemtime($cPath) >= filemtime($sourcePath)) {
        return $cPath;
    }
    createCacheDirectory(str_replace('../app', '', $sourcePath));
    $content = template(file_get_contents($sourcePath));
    file_put_contents($cPath, $content);
    return $cPath;
    
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
        return inject(createCacheViewFile($filename), $data);
    } else if (file_exists($filename.'.view')) {
        return inject(createCacheViewFile($filename.'.view'), $data);
    } else if (file_exists('../app/views/'.$filename)) {
        return inject(createCacheViewFile('../app/views/'.$filename), $data);
    } else if (file_exists('../app/views/'.$filename.'.view')) {
        return inject(createCacheViewFile('../app/views/'.$filename.'.view'), $data);
    }
    return '';
}

/**
 * Remplace les balises de modèle dans le contenu donné par leur code PHP correspondant.
 *
 * @param string $content Le contenu à traiter.
 * @return string Le contenu traité avec des balises de modèle remplacés.
 */
function template($content){
    $tmp = str_replace(
        [
            '@if',
            '@endif',
            '@elseif',
            '@else',
            '@while',
            '@endwhile',
            '@foreach',
            '@endforeach',
            '@for',
            '@endfor',
            '@switch',
            '@endswitch',
            '<%',
            '%>',
            '<@',
            '@>',
            ':@',
            '{@',
            '@}',
        ],
        [
            '<?php if',
            '<?php endif; ?>',
            '<?php elseif',
            '<?php else: ?>',
            '<?php while',
            '<?php endwhile; ?>',
            '<?php foreach',
            '<?php endforeach; ?>',
            '<?php for',
            '<?php endfor; ?>',
            '<?php switch',
            '<?php endswitch; ?>',
            '<?=',
            '?>',
            '<?php',
            '?>',
            ': ?>',
            '{ ?>',
            '<?php } ?>',
        ],
        $content
    );
    return minifyHTML(preg_replace(
        [
            '/%l\((.*?)\)/',
            '/%lh\((.*?)\)/',
            '/@include\((.*?)\)/',
            '/@include_once\((.*?)\)/',
            '/%view\((.*?)\)/',
            '/@dump\((.*?)\)/',
            '/@dbg\((.*?)\)/'
        ], 
        [
            '<?= l($1) ?>',
            '<?= lh($1) ?>',
            '<?php include($1); ?>',
            '<?php include_once($1); ?>',
            '<?= view($1); ?>',
            '<?php dump($1); ?>',
            '<?php dbg($1); ?>'
        ], 
        $tmp
    ));
}

/**
 * Minifie le contenu HTML donné en supprimant les espaces blancs et commentaires inutiles.
 *
 * @param string $html The HTML content to be minified.
 * @return string The minified HTML content.
 */
function minifyHTML($html) {
    if (getenv('APP_DEBUG')) return $html;
    // Supprimer les commentaires HTML
    $html = preg_replace('/<!--.*?-->/s', '', $html);

    // Supprimer les espaces inutiles entre les balises
    $html = preg_replace('/\s+</', '<', $html);
    $html = preg_replace('/>\s+/', '>', $html);

    // Supprimer les retours à la ligne et les espaces multiples
    $html = preg_replace('/\s{2,}/', ' ', $html);
    
    return trim($html);
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

function lh($text) {
    return htmlspecialchars(l($text), ENT_QUOTES, 'UTF-8'); 
}

function __($text) { 
     return l($text); 
}

/**
 * Affiche les arguments donnés si l'application est en mode débogage.
 *
 * @param mixed ...$args The arguments to be dumped.
 */
function dump(...$args) {
    if (!getenv('APP_DEBUG')) return;
    foreach ($args as $arg) {
        echo '<pre>';
        var_dump($arg);
        echo '</pre>';
    }
}

function dbg(...$args) {
    dump(...$args);
}

function dd(...$args) {
    if (!getenv('APP_DEBUG')) return;
    dump(...$args);
    die();
}