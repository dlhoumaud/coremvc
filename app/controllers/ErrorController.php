<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-25 15:10:08
 * @ Description: Controller pour les erreurs
 */
namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    public function e404()
    {
        header("HTTP/1.0 404 Not Found");
        $data = ['head_title' => 'Page inconnue', 'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'];
        $this->view('errors/404', $data);
    }

    public function e403()
    {
        header("HTTP/1.0 403 Access Denied");
        $data = ['head_title' => 'Accès interdit', 'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'];
        $this->view('errors/403', $data);
    }
}
