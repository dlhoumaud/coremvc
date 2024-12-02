<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:28:38
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-02 00:37:03
 * @ Description: Classe de contrôleur pour gérer les demandes HTTP et rendre les vues.
 */

 namespace App\Core;

class Controller
{
    /**
     * Charge un fichier d'affichage et le rend avec les données fournies.
     *
     * Cette méthode est responsable du chargement des fichiers de vue nécessaires, y compris la tête, l'en-tête et le pied de page, et de rendre le contenu principal de la vue.
     *
     * @param string $view Le nom du fichier Affichage à charger, sans l'extension .php.
     * @param array $data Un tableau de données facultatif à passer à la vue.
     */
    static protected function view($view, $data = [])
    {
        // Extraire les variables de $data
        extract($data);
        if (!isset($head_view_core)) $head_view_core = 'head';
        require_once "../app/views/core/$head_view_core.php";
        if (!isset($header_view_layout)) $header_view_layout = 'header';
        require_once "../app/views/layout/$header_view_layout.php";
        if (!isset($main_attributes)) echo '<main>';
        else echo '<main '.$main_attributes.'>';
        require_once "../app/views/$view.php";
        echo '</main>';
        if (!isset($footer_view_layout)) $footer_view_layout = 'footer';
        require_once "../app/views/layout/$footer_view_layout.php";
        if (!isset($end_view_core)) $end_view_core = 'end';
        require_once "../app/views/core/$end_view_core.php";
    }

}
