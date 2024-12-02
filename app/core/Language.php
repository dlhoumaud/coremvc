<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-02 00:51:35
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-02 01:12:11
 * @ Description: Classe de gestion des langues
 */
namespace App\Core;

class Language {

    static public function set_language() {
        // Vérifier si la langue est déjà définie dans le cookie
        if (isset($_GET['lang'])) {
            setcookie('lang', $_GET['lang'], time() + (3600 * 24 * 30), '/');
            $_COOKIE['lang'] = $_GET['lang']; // Charger la langue depuis le cookie
        }
        self::language();
    }
    
    static private function language() {
        // Vérifier si la langue est déjà définie dans le cookie
        if (isset($_COOKIE['lang'])) {
            $_SESSION['lang'] = $_COOKIE['lang']; // Charger la langue depuis le cookie
        } else {
            // Si la langue n'est pas définie dans le cookie, utiliser la langue du navigateur
            if (!isset($_SESSION['lang'])) {
                $_SESSION['lang'] = self::navigator_language(); // Langue du navigateur
            }

            // Sauvegarder la langue dans un cookie pour 30 jours
            setcookie('lang', $_SESSION['lang'], time() + (3600 * 24 * 30), '/'); // Expiration dans 30 jours
        }
    }

    static private function navigator_language() {
        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    static public function load_language() {
        $_SESSION['lang_controller'] = [];
        if (file_exists('../app/languages/'.($_SESSION['lang']??'en').'/'.($_SESSION['controller']??'').'.php')) {
            $_SESSION['lang_controller'] = include '../app/languages/'.($_SESSION['lang']??'en').'/'.($_SESSION['controller']??'').'.php';
        }
        $_SESSION['lang_global'] = [];
        if (file_exists('../app/languages/'.($_SESSION['lang']??'en').'/global.php')) {
            $_SESSION['lang_global'] = include '../app/languages/'.($_SESSION['lang']??'en').'/global.php';
        } 
    }
    
}