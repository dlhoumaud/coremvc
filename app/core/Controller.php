<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:28:38
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-25 14:22:44
 * @ Description: Controller class for handling HTTP requests and rendering views.
 */

 namespace App\Core;

class Controller
{
    /**
     * Loads a view file and renders it with the provided data.
     *
     * This method is responsible for loading the necessary view files, including the head, header, and footer, and rendering the main content of the view.
     *
     * @param string $view The name of the view file to load, without the .php extension.
     * @param array $data An optional array of data to pass to the view.
     */
    protected function view($view, $data = [])
    {
        // Extraire les variables de $data
        extract($data);
        if (!isset($head_view_core)) $head_view_core = 'head';
        require_once "../app/views/core/$head_view_core.php";
        if (!isset($header_view_layout)) $header_view_layout = 'header';
        require_once "../app/views/layout/$header_view_layout.php";
        if (!isset($main_attributes)) echo '<main id="app">';
        else echo '<main id="app" '.$main_attributes.'>';
        require_once "../app/views/$view.php";
        echo '</main>';
        if (!isset($footer_view_layout)) $footer_view_layout = 'footer';
        require_once "../app/views/layout/$footer_view_layout.php";
        if (!isset($end_view_core)) $end_view_core = 'end';
        require_once "../app/views/core/$end_view_core.php";
    }
}
