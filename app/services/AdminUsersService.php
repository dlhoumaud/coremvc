<?php
/**
 * @ Author: 
 * @ Create Time: 2024-12-02 20:06:03
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-02 21:08:38
 * @ Description: 
 */
namespace App\Services;

use App\Models\User;

class AdminUsersService
{
    static public function getAllUsers()
    {
        $userModel = new User();
        return $userModel->getAllUsers();
    }
}