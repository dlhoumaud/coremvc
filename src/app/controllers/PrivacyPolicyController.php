<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-02 13:28:20
 * @ Description: Controller pour la politique de confidentialité
 */
namespace App\Controllers;

use App\Core\Controller;

class PrivacyPolicyController extends Controller
{
    public function show() {
        $data = [
            'head_title' => l('title')
        ];
        self::view('privacy-policy', $data);
    }
}
