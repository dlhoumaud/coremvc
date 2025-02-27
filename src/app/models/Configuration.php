<?php
/**
 * @ Author:
 * @ Create Time: 2025-02-27 09:16:53
 * @ Modified by: GloomShade
 * @ Modified time: 2025-02-27 13:17:18
 * @ Description:
 */

//  CREATE TABLE `configurations` (
//     `id` int(11) NOT NULL AUTO_INCREMENT,
//     `key` varchar(255) DEFAULT NULL,
//     `type` enum('integer','float','bool','string','text') DEFAULT NULL,
//     `integer_value` int(11) DEFAULT NULL,
//     `float_value` decimal(10,0) DEFAULT NULL,
//     `bool_value` tinyint(1) DEFAULT NULL,
//     `string_value` varchar(255) DEFAULT NULL,
//     `text_value` text DEFAULT NULL,
//     PRIMARY KEY (`id`)
//   )

namespace App\Models;

use App\Core\Model;

class Configuration extends Model
{
    protected $table = 'configurations';
    protected $id;

    public function getAllConfiguration()
    {
        return $this->get();
    }

    public function getConfiguration($id)
    {
        $this->id = $id;
        return $this->where('id', '=', $id)->get(0);
    }

    public function key($key): mixed {
        $result = $this->where('config_key', '=', $key)->get(0);
        switch ($result['type']) {
            case 'integer':
                return intval($result['integer_value']);
            case 'float':
                return floatval($result['float_value']);
            case 'bool':
                return boolval($result['bool_value']);
            case 'string':
                return (string)$result['string_value'];
            case 'text':
                return (string)$result['text_value'];
            default:
                return $result;
        }
    }
}