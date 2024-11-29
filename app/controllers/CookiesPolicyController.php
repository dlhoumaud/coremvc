<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-29 12:44:48
 * @ Description: Controller pour la politique des cookies
 */
namespace App\Controllers;

use App\Core\Controller;

class CookiesPolicyController extends Controller
{
    public function show() {
        $data = [
            'head_title' => "Politique des Cookies"
        ];
        $this->view('cookies-policy', $data);
    }
}
