<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2025-03-12 16:18:12
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-12 16:48:39
 * @ Description: Permet de tester les fonctionnalités de l'application
 */


namespace App\Core;

class TestCase
{
    protected static function assertEquals($expected, $actual, $message = '')
    {
        if ($expected !== $actual) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu $expected, obtenu $actual.");
        }
    }

    protected static function assertNotEquals($expected, $actual, $message = '')
    {
        if ($expected === $actual) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu différent de $expected, obtenu $actual.");
        }
    }

    protected static function assertTrue($condition, $message = '')
    {
        if (!$condition) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu true, obtenu false.");
        }
    }

    protected static function assertFalse($condition, $message = '')
    {
        if ($condition) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu false, obtenu true.");
        }
    }

    protected static function assertNull($value, $message = '')
    {
        if ($value !== null) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu null, obtenu $value.");
        }
    }
    protected static function assertNotNull($value, $message = '')
    {
        if ($value === null) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu non null, obtenu null.");
        }
    }
    
    protected static function assertContains($needle, $haystack, $message = '')
    {
        if (!in_array($needle, $haystack)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu $needle dans $haystack, obtenu " . implode(', ', $haystack) . ".");
        }
    }

    protected static function assertNotContains($needle, $haystack, $message = '')
    {
        if (in_array($needle, $haystack)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu $needle pas dans $haystack, obtenu " . implode(', ', $haystack) . ".");
        }
    }

    protected static function assertEmpty($value, $message = '')
    {
        if (!empty($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu vide, obtenu " . implode(', ', $value) . ".");
        }
    }

    protected static function assertNotEmpty($value, $message = '')
    {
        if (empty($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu non vide, obtenu vide.");
        }
    }

    protected static function assertArrayHasKey($key, $array, $message = '')
    {
        if (!array_key_exists($key, $array)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu $key dans $array, obtenu " . implode(', ', array_keys($array)) . ".");
        }
    }

    protected static function assertArrayNotHasKey($key, $array, $message = '')
    {
        if (array_key_exists($key, $array)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu $key pas dans $array, obtenu " . implode(', ', array_keys($array)) . ".");
        }
    }
    
    protected static function assertInstanceOf($expectedClass, $actual, $message = '')
    {
        if (!$actual instanceof $expectedClass) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu une instance de $expectedClass, obtenu " . get_class($actual) . ".");
        }
    }

    protected static function assertNotInstanceOf($expectedClass, $actual, $message = '')
    {
        if ($actual instanceof $expectedClass) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu pas une instance de $expectedClass, obtenu " . get_class($actual) . ".");
        }
    }

    protected static function assertFileExists($filename, $message = '')
    {
        if (!file_exists($filename)) {
            throw new \Exception($message ?: "Échec de l'assertion : le fichier $filename n'existe pas.");
        }
    }
    
    protected static function assertFileNotExists($filename, $message = '')
    {
        if (file_exists($filename)) {
            throw new \Exception($message ?: "Échec de l'assertion : le fichier $filename existe.");
        }
    }

    protected static function assertDirectoryExists($directory, $message = '')
    {
        if (!is_dir($directory)) {
            throw new \Exception($message ?: "Échec de l'assertion : le répertoire $directory n'existe pas.");
        }
    }

    protected static function assertDirectoryNotExists($directory, $message = '')
    {
        if (is_dir($directory)) {
            throw new \Exception($message ?: "Échec de l'assertion : le répertoire $directory existe.");
        }
    }

    protected static function assertIsArray($value, $message = '')
    {
        if (!is_array($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu un tableau, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsString($value, $message = '')
    {
        if (!is_string($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu une chaîne de caractères, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsInt($value, $message = '')
    {
        if (!is_int($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu un entier, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsFloat($value, $message = '')
    {
        if (!is_float($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu un nombre à virgule flottante, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsBool($value, $message = '')
    {
        if (!is_bool($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu un booléen, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsObject($value, $message = '')
    {
        if (!is_object($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu un objet, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsCallable($value, $message = '')
    {
        if (!is_callable($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu une fonction ou une méthode, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsResource($value, $message = '')
    {
        if (!is_resource($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu une ressource, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsIterable($value, $message = '')
    {
        if (!is_iterable($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu un itérable, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsScalar($value, $message = '')
    {
        if (!is_scalar($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu un scalaire, obtenu " . gettype($value) . ".");
        }
    }

    protected static function assertIsNumeric($value, $message = '')
    {
        if (!is_numeric($value)) {
            throw new \Exception($message ?: "Échec de l'assertion : attendu un nombre, obtenu " . gettype($value) . ".");
        }
    }

    
    // Ajoute d'autres méthodes d'assertion selon les besoins
}
