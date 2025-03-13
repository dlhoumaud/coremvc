<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2025-03-12 16:18:12
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-13 00:43:27
 * @ Description: Permet de tester les fonctionnalités de l'application
 */


namespace App\Core;

use Exception;
use DateTime;
use App\Core\Mock;

class TestCase extends Mock
{
    protected static function assertEquals($expected, $actual, $message = '')
    {
        if ($expected !== $actual) {
            throw new Exception($message ?: "Échec de l'assertion : attendu $expected, obtenu $actual.");
        }
    }

    protected static function assertNotEquals($expected, $actual, $message = '')
    {
        if ($expected === $actual) {
            throw new Exception($message ?: "Échec de l'assertion : attendu différent de $expected, obtenu $actual.");
        }
    }

    protected static function assertTrue($condition, $message = '')
    {
        if (!$condition) {
            throw new Exception($message ?: "Échec de l'assertion : attendu true, obtenu false.");
        }
    }

    protected static function assertFalse($condition, $message = '')
    {
        if ($condition) {
            throw new Exception($message ?: "Échec de l'assertion : attendu false, obtenu true.");
        }
    }

    protected static function assertNull($value, $message = '')
    {
        if ($value !== null) {
            throw new Exception($message ?: "Échec de l'assertion : attendu null, obtenu $value.");
        }
    }
    protected static function assertNotNull($value, $message = '')
    {
        if ($value === null) {
            throw new Exception($message ?: "Échec de l'assertion : attendu non null, obtenu null.");
        }
    }
    
    protected static function assertContains($needle, $haystack, $message = '')
    {
        if (!in_array($needle, $haystack)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu $needle dans $haystack, obtenu " . implode(', ', $haystack) . ".");
        }
    }

    protected static function assertNotContains($needle, $haystack, $message = '')
    {
        if (in_array($needle, $haystack)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu $needle pas dans $haystack, obtenu " . implode(', ', $haystack) . ".");
        }
    }

    protected static function assertEmpty($value, $message = '')
    {
        if (!empty($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu vide, obtenu " . implode(', ', $value) . ".");
        }
    }

    protected static function assertNotEmpty($value, $message = '')
    {
        if (empty($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu non vide, obtenu vide.");
        }
    }

    protected static function assertArrayHasKey($key, $array, $message = '')
    {
        if (!array_key_exists($key, $array)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu $key dans $array, obtenu " . implode(', ', array_keys($array)) . ".");
        }
    }

    protected static function assertArrayNotHasKey($key, $array, $message = '')
    {
        if (array_key_exists($key, $array)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu $key pas dans $array, obtenu " . implode(', ', array_keys($array)) . ".");
        }
    }
    
    protected static function assertInstanceOf($expectedClass, $actual, $message = '')
    {
        if (!$actual instanceof $expectedClass) {
            throw new Exception($message ?: "Échec de l'assertion : attendu une instance de $expectedClass, obtenu " . get_class($actual) . ".");
        }
    }

    protected static function assertNotInstanceOf($expectedClass, $actual, $message = '')
    {
        if ($actual instanceof $expectedClass) {
            throw new Exception($message ?: "Échec de l'assertion : attendu pas une instance de $expectedClass, obtenu " . get_class($actual) . ".");
        }
    }

    protected static function assertFileExists($filename, $message = '')
    {
        if (!file_exists($filename)) {
            throw new Exception($message ?: "Échec de l'assertion : le fichier $filename n'existe pas.");
        }
    }
    
    protected static function assertFileNotExists($filename, $message = '')
    {
        if (file_exists($filename)) {
            throw new Exception($message ?: "Échec de l'assertion : le fichier $filename existe.");
        }
    }

    protected static function assertDirectoryExists($directory, $message = '')
    {
        if (!is_dir($directory)) {
            throw new Exception($message ?: "Échec de l'assertion : le répertoire $directory n'existe pas.");
        }
    }

    protected static function assertDirectoryNotExists($directory, $message = '')
    {
        if (is_dir($directory)) {
            throw new Exception($message ?: "Échec de l'assertion : le répertoire $directory existe.");
        }
    }

    protected static function assertIsArray($value, $message = '')
    {
        if (!is_array($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un tableau, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsString($value, $message = '')
    {
        if (!is_string($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu une chaîne de caractères, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsInt($value, $message = '')
    {
        if (!is_int($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un entier, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsPositiveInt($value, $message = '')
    {
        if (!is_int($value) || $value <= 0) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un entier positif, obtenu " . var_export($value, true) . ".");
        }
    }

    protected static function assertIsNegativeInt($value, $message = '')
    {
        if (!is_int($value) || $value >= 0) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un entier négatif, obtenu " . var_export($value, true) . ".");
        }
    }


    protected static function assertIsFloat($value, $message = '')
    {
        if (!is_float($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un nombre à virgule flottante, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertFloatEquals($expected, $actual, $delta = 0.0001, $message = '')
    {
        if (abs($expected - $actual) > $delta) {
            throw new Exception($message ?: "Échec de l'assertion : attendu environ $expected, obtenu $actual.");
        }
    }

    protected static function assertIsBool($value, $message = '')
    {
        if (!is_bool($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un booléen, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsObject($value, $message = '')
    {
        if (!is_object($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un objet, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsCallable($value, $message = '')
    {
        if (!is_callable($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu une fonction ou une méthode, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsResource($value, $message = '')
    {
        if (!is_resource($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu une ressource, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsIterable($value, $message = '')
    {
        if (!is_iterable($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un itérable, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsScalar($value, $message = '')
    {
        if (!is_scalar($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un scalaire, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsNumeric($value, $message = '')
    {
        if (!is_numeric($value)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu un nombre, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertStringStartsWith($prefix, $string, $message = '')
    {
        if (strpos($string, $prefix) !== 0) {
            throw new Exception($message ?: "Échec de l'assertion : attendu que '$string' commence par '$prefix'.");
        }
    }

    protected static function assertStringEndsWith($suffix, $string, $message = '')
    {
        if (substr($string, -strlen($suffix)) !== $suffix) {
            throw new Exception($message ?: "Échec de l'assertion : attendu que '$string' se termine par '$suffix'.");
        }
    }

    protected static function assertStringContainsString($needle, $haystack, $message = '')
    {
        if (strpos($haystack, $needle) === false) {
            throw new Exception($message ?: "Échec de l'assertion : attendu que '$haystack' contienne '$needle'.");
        }
    }

    protected static function assertMatchesRegex($pattern, $string, $message = '')
    {
        if (!preg_match($pattern, $string)) {
            throw new Exception($message ?: "Échec de l'assertion : '$string' ne correspond pas au motif '$pattern'.");
        }
    }

    protected static function assertArrayEqualsIgnoringOrder($expected, $actual, $message = '')
    {
        if (count($expected) !== count($actual) || array_diff($expected, $actual) || array_diff($actual, $expected)) {
            throw new Exception($message ?: "Échec de l'assertion : les tableaux ne contiennent pas les mêmes éléments.");
        }
    }
    protected static function assertArrayEquals($expected, $actual, $message = '')
    {
        if ($expected !== $actual) {
            throw new Exception($message ?: "Échec de l'assertion : attendu $expected, obtenu $actual.");
        }
    }

    protected static function assertArrayNotEquals($expected, $actual, $message = '')
    {
        if ($expected === $actual) {
            throw new Exception($message ?: "Échec de l'assertion : attendu différent de $expected, obtenu $actual.");
        }
    }

    protected static function assertArrayContainsOnlyType($type, $array, $message = '')
    {
        foreach ($array as $value) {
            if (gettype($value) !== $type) {
                throw new Exception($message ?: "Échec de l'assertion : attendu un tableau de $type, obtenu un tableau de " . gettype($value) . ".");
            }
        }
    }

    protected static function assertArrayNotContainsType($type, $array, $message = '')
    {
        foreach ($array as $value) {
            if (gettype($value) === $type) {
                throw new Exception($message ?: "Échec de l'assertion : attendu un tableau ne contenant pas de $type, obtenu un tableau de " . gettype($value) . ".");
            }
        }
    }

    protected static function assertArrayContains($needle, $haystack, $message = '')
    {
        if (!in_array($needle, $haystack)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu $needle dans $haystack, obtenu " . implode(', ', $haystack) . ".");
        }
    }

    protected static function assertArrayNotContains($needle, $haystack, $message = '')
    {
        if (in_array($needle, $haystack)) {
            throw new Exception($message ?: "Échec de l'assertion : attendu $needle pas dans $haystack, obtenu " . implode(', ', $haystack) . ".");
        }
    }

    protected static function assertIsJsonString($value, $message = '')
    {
        if (!is_string($value) || !is_array(json_decode($value, true))) {
            throw new Exception($message ?: "Échec de l'assertion : attendu une chaîne JSON, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsYamlString($value, $message = '')
    {
        if (function_exists('yaml_parse')) {
            if (!is_string($value) || !is_array(yaml_parse($value))) {
                throw new Exception($message ?: "Échec de l'assertion : attendu une chaîne YAML, obtenu " . gettype($value) . ".");
            }
        } else {
            throw new Exception($message ?: "Échec de l'assertion : la fonction yaml_parse n'est pas disponible.");
        }
    }

    protected static function assertIsUTF8String($value, $message = '')
    {
        if (function_exists('mb_check_encoding')) {
            if (!is_string($value) || !mb_check_encoding($value, 'UTF-8')) {
                throw new Exception($message ?: "Échec de l'assertion : attendu une chaîne UTF-8, obtenu " . gettype($value) . ".");
            }
        } else {
            throw new Exception($message ?: "Échec de l'assertion : la fonction mb_check_encoding n'est pas disponible.");
        }
    }

    protected static function assertIsValidEmail($email, $message = '')
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception($message ?: "Échec de l'assertion : '$email' n'est pas un email valide.");
        }
    }
    
    protected static function assertIsValidUrl($url, $message = '')
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception($message ?: "Échec de l'assertion : '$url' n'est pas une URL valide.");
        }
    }

    protected static function assertIsValidIp($ip, $message = '')
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new Exception($message ?: "Échec de l'assertion : '$ip' n'est pas une adresse IP valide.");
        }
    }

    protected static function assertIsValidPhoneNumber($phoneNumber, $message = '')
    {
        if (!preg_match('/^\+?[0-9]{10,15}$/', $phoneNumber)) {
            throw new Exception($message ?: "Échec de l'assertion : '$phoneNumber' n'est pas un numéro de téléphone valide.");
        }
    }

    protected static function assertIsValidDate($date, $format = 'Y-m-d', $message = '')
    {
        $d = DateTime::createFromFormat($format, $date);
        if (!$d || $d->format($format) !== $date) {
            throw new Exception($message ?: "Échec de l'assertion : '$date' n'est pas une date valide.");
        }
    }
    
    protected static function assertIsValidTime($time, $format = 'H:i:s', $message = '')
    {
        $d = DateTime::createFromFormat($format, $time);
        if (!$d || $d->format($format) !== $time) {
            throw new Exception($message ?: "Échec de l'assertion : '$time' n'est pas un temps valide.");
        }
    }

    protected static function assertIsValidDateTime($dateTime, $format = 'Y-m-d H:i:s', $message = '')
    {
        $d = DateTime::createFromFormat($format, $dateTime);
        if (!$d || $d->format($format) !== $dateTime) {
            throw new Exception($message ?: "Échec de l'assertion : '$dateTime' n'est pas une date et heure valide.");
        }
    }

    protected static function assertIsValidTimestamp($timestamp, $message = '')
    {
        if (!is_int($timestamp) || $timestamp < 0) {
            throw new Exception($message ?: "Échec de l'assertion : '$timestamp' n'est pas un timestamp valide.");
        }
    }

    protected static function assertIsValidHexColor($color, $message = '')
    {
        if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            throw new Exception($message ?: "Échec de l'assertion : '$color' n'est pas une couleur hexadécimale valide.");
        }
    }

    protected static function assertIsXMLString($xmlString, $message = '')
    {
        if (function_exists('simplexml_load_string')) {
            if (!is_string($xmlString) || !simplexml_load_string($xmlString)) {
                throw new Exception($message ?: "Échec de l'assertion : '$xmlString' n'est pas une chaîne XML valide.");
            }
        } else {
            throw new Exception($message ?: "Échec de l'assertion : la fonction simplexml_load_string n'est pas disponible.");
        }
    }

    protected static function assertIsSerializeString($serializedString, $message = '')
    {
        if (function_exists('unserialize')) {
            if (!is_string($serializedString) || !unserialize($serializedString)) {
                throw new Exception($message ?: "Échec de l'assertion : '$serializedString' n'est pas une chaîne sérialisée valide.");
            }
        } else {
            throw new Exception($message ?: "Échec de l'assertion : la fonction unserialize n'est pas disponible.");
        }
    }

    protected static function assertIsISOCode2($isoCode2, $message = '')
    {
        if (!preg_match('/^[A-Z]{2}$/', $isoCode2)) {
            throw new Exception($message ?: "Échec de l'assertion : '$isoCode2' n'est pas un code ISO 3166-1 alpha-2 valide.");
        }
    }
    
    protected static function assertIsISOCode3($isoCode3, $message = '')
    {
        if (!preg_match('/^[A-Z]{3}$/', $isoCode3)) {
            throw new Exception($message ?: "Échec de l'assertion : '$isoCode3' n'est pas un code ISO 3166-1 alpha-3 valide.");
        }
    }

    protected static function assertIsImageFile($filePath, $message = '')
    {
        if (!file_exists($filePath) || !is_file($filePath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'existe pas ou n'est pas un fichier.");
        }
        if (!is_readable($filePath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'est pas accessible en lecture.");
        }
        if (function_exists('getimagesize')) {
            $imageInfo = getimagesize($filePath);
            if (!$imageInfo || !in_array($imageInfo[2], array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP, IMAGETYPE_WEBP, IMAGETYPE_AVIF, IMAGETYPE_ICO))) {
                throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'est pas un fichier image valide.");
            }
        } else {
            throw new Exception($message ?: "Échec de l'assertion : la fonction getimagesize n'est pas disponible.");
        }
    }

    protected static function assertIsReadableFile($filePath, $message = '')
    {
        if (!file_exists($filePath) || !is_file($filePath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'existe pas ou n'est pas un fichier.");
        }
        if (!is_readable($filePath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'est pas accessible en lecture.");
        }
    }

    protected static function assertIsReadableDirectory($directoryPath, $message = '')
    {
        if (!file_exists($directoryPath) || !is_dir($directoryPath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$directoryPath' n'existe pas ou n'est pas un répertoire.");
        }
        if (!is_readable($directoryPath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$directoryPath' n'est pas accessible en lecture.");
        }
    }

    protected static function assertIsWritableFile($filePath, $message = '')
    {
        if (!file_exists($filePath) || !is_file($filePath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'existe pas ou n'est pas un fichier.");
        }
        if (!is_writable($filePath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'est pas accessible en écriture.");
        }
    }

    protected static function assertIsWritableDirectory($directoryPath, $message = '')
    {
        if (!file_exists($directoryPath) || !is_dir($directoryPath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$directoryPath' n'existe pas ou n'est pas un répertoire.");
        }
        if (!is_writable($directoryPath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$directoryPath' n'est pas accessible en écriture.");
        }
    }

    protected static function assertIsExecutableFile($filePath, $message = '')
    {
        if (!file_exists($filePath) || !is_file($filePath)) {
            throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'existe pas ou n'est pas un fichier.");
        }
        if (!is_executable($filePath || !is_executable($filePath))) {
            throw new Exception($message ?: "Échec de l'assertion : '$filePath' n'est pas exécutable.");
        }
    }
    
}
