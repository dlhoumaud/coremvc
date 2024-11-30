<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-30 15:29:50
 * @ Description: Controller pour la page d'accueil
 */
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Session;
use App\Services\HomeService;

class HomeController extends Controller
{
    public function index()
    {
        Session::set('title', 'Bienvenue sur CoreMVC');
        $data = [
            'head_title' => Session::get('title'),
            'vue_components' => HomeService::getVueComponents()
        ];
        self::view('home', $data);
    }

    public function about()
    {
        Session::set('title', 'À propos de CoreMVC');
        $data = ['head_title' => Session::get('title')];
        self::view('about', $data);
    }
}
