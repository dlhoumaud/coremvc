<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-02 14:17:13
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-06 10:46:12
 * @ Description: Controller pour la page d'administration
 */
namespace App\Controllers;

use App\Core\Controller;

class AdminReportsController extends Controller
{
    public function show()
    {
        if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
            header('Location: /login');
            exit;
        }
        $data = [
            'head_title' => l('reports'),
            'head_description' => l('welcome_dashboard_description'),
            'vue_components' => [
                'card/title-icon-top.min'
            ]
        ];
        self::view('admin/reports', $data);
    }
}