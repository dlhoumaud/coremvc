<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-02 14:17:13
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-06 11:42:49
 * @ Description: Controller pour la page d'administration
 */
namespace App\Controllers;

use App\Core\Controller;

class AdminSettingsController extends Controller
{
    public function show()
    {
        if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
            header('Location: /login');
            exit;
        }
        $data = [
            'head_title' => l('settings'),
            'head_description' => l('welcome_dashboard_description'),
            'vue_components' => [
                'card/title-icon-top.min',
                'breadcrumb.min'
            ]
        ];
        self::view('admin/settings', $data);
    }
}