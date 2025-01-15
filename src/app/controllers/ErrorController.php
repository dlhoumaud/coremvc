<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-18 14:15:26
 * @ Description: Controller pour les erreurs
 */
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Error;

class ErrorController extends Controller
{
    static public function e404()
    {
        Error::header(404);
        $data = ['head_title' => 'Page inconnue', 'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'];
        self::view('errors/404', $data);
    }

    static public function e403()
    {
        Error::header(403);
        $data = ['head_title' => 'Accès interdit', 'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'];
        self::view('errors/403', $data);
    }

    static public function e405()
    {
        Error::header(405);
        $data = ['head_title' => 'Méthode non autorisée', 'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'];
        self::view('errors/404', $data);
    }
}
