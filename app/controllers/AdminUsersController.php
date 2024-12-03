<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-02 19:10:10
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-02 21:38:33
 * @ Description: 
 */
namespace App\Controllers;

use App\Core\Controller;
use App\Services\AdminUsersService;

class AdminUsersController extends Controller
{
    static private function is_logged(): void
    {
        if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
            header('Location: /login');
            exit;
        }
    }
    
    public function list()
    {
        self::is_logged();
        $data = [
            'head_title' => l('users_list'),
            'head_description' => l('users_list'),
            'users' => AdminUsersService::getAllUsers()
        ];
        self::view('admin/users', $data);
    }

    public function user_edit($id)
    {
        self::is_logged();
        header('Location: /admin/users');
    }

    public function user_delete($id)
    {
        self::is_logged();
        header('Location: /admin/users');
    }

    public function user_add()
    {
        self::is_logged();
        header('Location: /admin/users');
    }
}