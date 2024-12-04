<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-04 11:01:24
 * @ Description: Classe pour gérer les utilisateurs
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    
    public function login()
    {
        $data = [
            'head_title' => l('login_head_title'), 
            'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userService->authenticate($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['is_logged'] = true;
                header('Location: /admin/dashboard');
                exit;
            } else {
                $data['error'] = l('login_error');
                $_SESSION['is_logged'] = false;
            }
        }

        self::view('login', $data);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['is_logged']);
        header('Location: /');
    }

    public function show($id)
    {
        $data = $this->userService->getUser($id);
        self::view('user', $data);
    }
}
