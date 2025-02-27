
<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: GloomShade
 * @ Modified time: 2025-02-27 12:58:34
 * @ Description: Script de fonctionnalités
 */

/**
 * Chiffre le contenu d'un fichier .env et l'enregistre dans un nouveau fichier.
 *
 * @param string $inputFile  Le chemin du fichier .env à chiffrer.
 * @param string $outputFile Le chemin du fichier de sortie chiffré.
 * @param string $key        La clé de chiffrement (doit être de 32 caractères pour AES-256-CBC).
 * @return void
 */
function encryptFile($inputFile, $outputFile, $key): void
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
 * @return void
 */
function decryptFile($inputFile, $outputFile, $key): void
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
 * Analyse le répertoire spécifié et renvoie un tableau de fichiers / répertoires.
 *
 * @param string $directory The directory to scan.
 * @return array An array of files/directories in the specified directory, excluding "." and "..".
 * @throws Exception If the specified directory does not exist.
 */
function scanDirectory($directory): array
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

/**
 * Exécute une migration en fonction du type spécifié (up ou down).
 *
 * @param Database $db     Instance de la classe Database pour la connexion.
 * @param string $file     Chemin du fichier de migration.
 * @param string $type     Type de migration à exécuter ('up' pour créer, 'down' pour supprimer).
 * @return void
 * @throws Exception       Lance une exception si le type est incorrect ou en cas d'erreur SQL.
 */
function runMigration($pdo, string $file, string $type = 'up', bool $is_seed = false)
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
        $pdo->raw($query);
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

/**
 * Crée une nouvelle classe de contrôleur pour l'application.
 *
 * @param string $name Le nom du contrôleur à créer.
 * @param string $service_commentary mettre en commentaire l'appel du service
 */
function createController($name, $service_commentary="// ") {
    $content = "<?php
/**
 * @ Author: 
 * @ Create Time: ".date("Y-m-d H:i:s")."
 * @ Modified by: 
 * @ Modified time: ".date("Y-m-d H:i:s")."
 * @ Description: 
 */
namespace App\Controllers;

use App\Core\Controller;
".$service_commentary."use App\Services\\".ucfirst($name)."Service;

class ".ucfirst($name)."Controller extends Controller
{
    public function show()
    {
        \$data = [
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
        self::view('".strtolower($name)."', \$data);
    }
}";
    file_put_contents('app/controllers/'.ucfirst($name).'Controller.php', $content);
}

/**
 * Crée une nouvelle classe de service pour l'application.
 *
 * @param string $name Le nom du service à créer.
 */
function createService($name) {
    $content = "<?php
/**
 * @ Author: 
 * @ Create Time: ".date("Y-m-d H:i:s")."
 * @ Modified by: 
 * @ Modified time: ".date("Y-m-d H:i:s")."
 * @ Description: 
 */
namespace App\Services;

class ".ucfirst($name)."Service
{
    public function __construct()
    {
        /// Initialisation du service
    }
}";
    file_put_contents('app/services/'.ucfirst($name).'Service.php', $content);
}

/**
 * Crée une nouvelle classe de modèle pour l'application.
 *
 * @param string $name Le nom du modèle à créer.
 */
function createModel($name) {
    $content = "<?php
/**
 * @ Author:
 * @ Create Time: ".date("Y-m-d H:i:s")."
 * @ Modified by:
 * @ Modified time: ".date("Y-m-d H:i:s")."
 * @ Description:
 */
namespace App\Models;

use App\Core\Model;

class ".ucfirst($name)." extends Model
{
    protected \$table = '".strtolower($name)."';
    protected \$id;

    public function getAll".ucfirst($name)."()
    {
        return \$this->get();
    }

    public function get".ucfirst($name)."(\$id)
    {
        \$this->id = \$id;
        return \$this->where('id', '=', \$id)->get(0);
    }
}";
    file_put_contents('app/models/'.ucfirst($name).'.php', $content);
}