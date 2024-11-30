<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-29 13:11:16
 * @ Description: Controller pour les erreurs
 */
namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    static public function e404()
    {
        header("HTTP/1.0 404 Not Found");
        $data = ['head_title' => 'Page inconnue', 'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'];
        self::view('errors/404', $data);
    }

    static public function e403()
    {
        header("HTTP/1.0 403 Access Denied");
        $data = ['head_title' => 'Accès interdit', 'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'];
        self::view('errors/403', $data);
    }

    static public function e405()
    {
        header("HTTP/1.0 405 Method Not Allowed");
        $data = ['head_title' => 'Méthode non autorisée', 'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'];
        self::view('errors/404', $data);
    }
}
