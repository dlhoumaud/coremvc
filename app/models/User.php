<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 14:20:49
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-03 15:50:35
 * @ Description: Modele pour les utilisateurs
 */
namespace App\Models;

use App\Core\Model;
use App\Models\UserProfile;

class User extends Model
{
    protected $table = 'users';
    protected $id;

    public function getAllUsers()
    {
        return $this->get();
    }

    public function getUser($id)
    {
        $this->id = $id;
        return $this->where('id', '=', $id)->get(0);
    }

    public function deleteUser($id)
    {
        return $this->where('id', '=', $id)->delete();
    }

    public function findUserByEmail($email) {
        return $this->where('email', '=', $email)->get(0);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

}