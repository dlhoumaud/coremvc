<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 12:01:04
 * @ Description:
 */
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Bienvenue sur CoreMVC'];
        $this->view('home', $data);
    }

    public function about()
    {
        $data = ['title' => 'À propos de CoreMVC'];
        $this->view('about', $data);
    }
}
