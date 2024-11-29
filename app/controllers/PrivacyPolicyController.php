<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-29 12:31:41
 * @ Description: Controller pour la politique de confidentialité
 */
namespace App\Controllers;

use App\Core\Controller;

class PrivacyPolicyController extends Controller
{
    public function show() {
        $data = [
            'head_title' => "Politique de confidentialité"
        ];
        $this->view('privacy-policy', $data);
    }
}
