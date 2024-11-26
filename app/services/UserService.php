<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 14:40:04
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-25 16:22:06
 * @ Description: Services pour les utilisateurs
 */
namespace App\Services;

use App\Models\User;

class UserService
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function authenticate($username, $password)
    {
        $user = $this->userModel->findUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    public function getAllUsers()
    {
        return $this->userModel->getAllUsers();
    }

    public function getUser($id)
    {
        // Récupérer l'utilisateur avec l'ID donné depuis le modèle User
        $user = $this->userModel->getUser($id);
    
        if ($user) {
            // Si l'utilisateur existe, transmettre les données à la vue
            return [
                'title' => 'Utilisateur ' . $user['firstname'] . ' ' . $user['lastname'],
                'vue_datas' => '
                    firstname : "'.$user['firstname'].'",
                    lastname : "'.$user['lastname'].'",
                    email : "'.$user['email'].'",
                ',
                'vue_methods' => '
                    mouseEnter : '.inject('js/controllers/user/alert.js', ['user' => $user, 'hover'=> true ]).',
                    mouseLeave : '.inject('js/controllers/user/alert.js', ['user' => $user, 'hoverOut'=> true ]).',
                    click : '.inject('js/controllers/user/alert.js', ['user' => $user])
            ];
        } 
        // Si l'utilisateur n'existe pas, afficher une erreur ou rediriger
        return [
            'title' => 'Utilisateur introuvable',
            'message' => 'L\'utilisateur avec l\'ID ' . $id . ' n\'existe pas.',
            'user' => [
                'id' => $id,
                'firstname' => 'Utilisateur',
                'lastname' => 'Inconnu',
                'email' => 'utilisateur@inconnu.com'
            ]
        ];
    }
}