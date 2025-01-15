<?php
/**
 * @ Author: 
 * @ Create Time: 2024-12-18 08:34:17
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-18 15:46:20
 * @ Description: 
 */
namespace App\Services;

use App\Services\UserService;
use App\Models\User;

class APIUserService
{
    
    static public function login(): array {
        $UserService = new UserService();
        return $UserService->authenticate($_POST['email'], $_POST['password']);
    }

    static public function getArticles($id) {
        $userModel = new User();
        $userModel->getUser($id);
        return $userModel->articles();
    }
}