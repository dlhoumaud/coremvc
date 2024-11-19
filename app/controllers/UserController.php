<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 12:01:20
 * @ Description:
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
            'title' => 'Connexion à CoreMVC', 
            'main_attributes' => 'class="form-signin col-8 col-sm-6 col-md-4 col-lg-3 m-auto"'
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userService->authenticate($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: /dashboard');
                exit;
            } else {
                $data['error'] = 'Nom d\'utilisateur ou mot de passe incorrect';
            }
        }

        $this->view('login', $data);
    }

    public function show($id)
    {
        $data = $this->userService->getUser($id);
        $this->view('user', $data);
    }
}
