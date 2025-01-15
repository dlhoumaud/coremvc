<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-02 00:51:35
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-02 12:16:05
 * @ Description: Classe de gestion des langues
 */
namespace App\Core;

class Language {

    /**
     * Définit le langage préféré de l'utilisateur en fonction du paramètre de requête «Lang».
     * 
     * Cette méthode vérifie si le paramètre «Lang» est défini dans l'URL.Si c'est le cas, il définit un cookie avec le
     * Langue sélectionnée et la stocke dans la session.Il appelle ensuite la méthode `Language () 'à charger
     * Les fichiers linguistiques appropriés.
     */
    static public function set_language() {
        // Vérifier si la langue est déjà définie dans le cookie
        if (isset($_GET['lang'])) {
            setcookie('lang', $_GET['lang'], time() + (3600 * 24 * 30), '/');
            $_COOKIE['lang'] = $_GET['lang']; // Charger la langue depuis le cookie
        }
        self::language();
    }
    
    /**
     * Détermine le langage préféré de l'utilisateur en fonction de l'en-tête http_accept_language.
     * 
     * Cette fonction privée est utilisée en interne par la classe de langue pour déterminer le préféré de l'utilisateur
     * Langue lorsqu'elle n'est pas définie dans un cookie ou une session.Il extrait les deux premiers caractères du
     * En-tête http_accept_language, qui représente généralement le code de la langue.
     *
     * @return string Le code linguistique à deux lettres basé sur les paramètres du navigateur de l'utilisateur.
     */
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

    /**
     * Récupère le code de langue du navigateur de l'utilisateur en fonction de l'en-tête http_accept_language.
     *
     * Cette fonction privée est utilisée en interne par la classe de langue pour déterminer le préféré de l'utilisateur
     * Langue lorsqu'elle n'est pas définie dans un cookie ou une session.Il extrait les deux premiers caractères du
     * L'en-tête http_accept_language, qui représente généralement le code linguistique.
     *
     * @return string Le code linguistique à deux lettres basé sur les paramètres du navigateur de l'utilisateur.
     */
    static private function navigator_language() {
        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    /**
     * Charge les fichiers linguistiques pour le contrôleur actuel et les chaînes de langue globales.
     * 
     * Cette méthode vérifie d'abord si un fichier linguistique existe pour le contrôleur actuel et le
     * Langue sélectionnée de l'utilisateur.Sinon, il retombe dans le fichier de langue anglaise.Il alors
     * Charge le fichier de langue globale pour la langue sélectionnée de l'utilisateur, ou l'anglais
     * Fichier linguistique si le fichier linguistique spécifique n'existe pas.
     * 
     * Les chaînes de langue chargées sont stockées dans la `$ _SESSION ['lang_controller']` et
     * `$ _SESSION ['Lang_global']` Arrays, respectivement.
     */
    static public function load_language() {
        $_SESSION['lang_controller'] = [];
        if (file_exists('../app/languages/'.($_SESSION['lang']??'en').'/'.($_SESSION['controller']??'').'.php')) {
            $_SESSION['lang_controller'] = include '../app/languages/'.($_SESSION['lang']??'en').'/'.($_SESSION['controller']??'').'.php';
        } else if (file_exists('../app/languages/en/'.($_SESSION['controller']??'').'.php')) {
            $_SESSION['lang_controller'] = include '../app/languages/en/'.($_SESSION['controller']??'').'.php';
        }
        $_SESSION['lang_global'] = [];
        if (file_exists('../app/languages/'.($_SESSION['lang']??'en').'/global.php')) {
            $_SESSION['lang_global'] = include '../app/languages/'.($_SESSION['lang']??'en').'/global.php';
        } else if (file_exists('../app/languages/en/global.php')) {
            $_SESSION['lang_global'] = include '../app/languages/en/global.php';
        }
    }
    
}