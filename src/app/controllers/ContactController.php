<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-01 22:08:42
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-01 23:34:34
 * @ Description: 
 */
namespace App\Controllers;

use App\Core\Controller;
use App\Services\ContactService;

class ContactController extends Controller
{
    public function show()
    {
        $data = [
            'head_title' => 'Contactez-nous',
            'head_description' => 'Formulaire de contact',
            'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"',
        ];
        self::view('contact', $data);
    }
}