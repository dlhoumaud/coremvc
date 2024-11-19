<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 14:20:49
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 13:55:18
 * @ Description: Modele pour les utilisateurs
 */
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';

    public function getAllUsers()
    {
        return $this->get();
    }

    public function getUser($id)
    {
        return $this->where('id', '=', $id)->get(0);
    }

    public function deleteUser($id)
    {
        return $this->where('id', '=', $id)->delete();
    }

}