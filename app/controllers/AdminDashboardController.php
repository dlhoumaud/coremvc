<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-02 14:17:13
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-02 20:06:11
 * @ Description: Controller pour la page d'administration
 */
namespace App\Controllers;

use App\Core\Controller;

class AdminDashboardController extends Controller
{
    public function show()
    {
        if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
            header('Location: /login');
            exit;
        }
        $data = [
            'head_title' => l('dashboard'),
            'head_description' => l('welcome_dashboard_description'),
        ];
        self::view('admin/dashboard', $data);
    }
}