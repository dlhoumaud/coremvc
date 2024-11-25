<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-25 15:09:59
 * @ Description: Controller pour la page d'accueil
 */
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Session;

class HomeController extends Controller
{
    public function index()
    {
        Session::set('title', 'Bienvenue sur CoreMVC');
        $data = ['head_title' => Session::get('title')];
        $this->view('home', $data);
    }

    public function about()
    {
        Session::set('title', 'À propos de CoreMVC');
        $data = ['head_title' => Session::get('title')];
        $this->view('about', $data);
    }
}
