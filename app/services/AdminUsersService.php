<?php
/**
 * @ Author: 
 * @ Create Time: 2024-12-02 20:06:03
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-05 15:51:13
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

    static public function getArticles($id)
    {
        $userModel = new User();
        return [ 
            'user' => $userModel->getUser($id),
            'articles' => $userModel->articles(),
        ];
    }

    static public function getArticle($id, $idArticle)
    {
        $userModel = new User();
        return [ 
            'user' => $userModel->getUser($id),
            'article' => $userModel->article($idArticle),
        ];
    }
}