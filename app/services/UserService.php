<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 14:40:04
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-02 13:34:36
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
                'head_title' => l('user').' ' . $user['firstname'] . ' ' . $user['lastname'],
                'title' => l('user').' ' . $user['firstname'] . ' ' . $user['lastname'],
                'vue_datas' => [
                    'firstname' => $user['firstname'],
                    'lastname'  => $user['lastname'],
                    'email'     => $user['email']
                ],
                'vue_methods' => [
                    'mouseEnter' => inject('js/methods/user/btn-card.js', ['user' => $user, 'hover'   => true ]),
                    'mouseLeave' => inject('js/methods/user/btn-card.js', ['user' => $user, 'hoverOut'=> true ]),
                    'click'      => inject('js/methods/user/btn-card.js', ['user' => $user]),
                ],
                'vue_components' => ['card/img-top']
            ];
        } 
        // Si l'utilisateur n'existe pas, afficher une erreur ou rediriger
        return [
            'head_title' => l('user_not_found'),
            'title' => l('user_not_found'),
            'message' => str_replace(':user_id', $id, l('message_user_id_not_found')),
            'vue_datas' => [
                'firstname' => l('user'),
                'lastname' => l('unknown'),
                'email' => 'utilisateur@inconnu.com'
            ]
        ];
    }
}