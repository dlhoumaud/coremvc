<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-12-03 14:15:43
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-05 15:21:39
 * @ Description: Model pour les article d'un utilisateur
 */

namespace App\Models;

use App\Core\Model;

use App\Models\User;

class Article extends Model
{
    protected $table = 'articles';
    protected $id;

    public function getArticle($id)
    {
        $this->id=$id;
        return $this->where('id', '=', $id)->get(0);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}