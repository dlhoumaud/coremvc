<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-03 14:15:43
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-03 15:48:24
 * @ Description: Model pour les profils utilisateur
 */

namespace App\Models;

use App\Core\Model;

use App\Models\User;

class UserProfile extends Model
{
    protected $table = 'users_profiles';
    protected $id;

    public function getUserProfile($id)
    {
        $this->id=$id;
        return $this->where('id', '=', $id)->get(0);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}