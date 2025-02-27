<?php
/**
 * @ Author: 
 * @ Create Time: 2025-02-27 09:16:53
 * @ Modified by: GloomShade
 * @ Modified time: 2025-02-27 13:51:49
 * @ Description: 
 */
namespace App\Services;

use App\Models\Configuration;
use App\Models\Article;

class ConfigurationService
{
    static public function getAllConfiguration() {
        $configuration = new Configuration();
        if ($configuration) {
            return [
                'articles_numbers_by_page' => $configuration->key('articles_numbers_by_page'),
                'site_name' => $configuration->key('site_name'),
                'site_description' => $configuration->key('site_description'),
            ];

        }

        return [
            'error' => [
                'code' => 404,
                'message' => 'Configuration not found'
            ]
        ];
    }

    static public function articles($limit, $offset) {
        $article = new Article();
        return ['articles' => $article->list($limit, $offset)];
    }

    static public function paginate($limit) {
        $paginate = [
            'paginate' => [
                'offset' => 0,
                'previous' => 1,
                'current' => 1,
                'next' => 2,
                'max' => $limit,
            ]
        ];
        if (isset($_GET['page'])) {
            if ($_GET['page'] > 1) {
                $paginate['paginate']['previous'] = $_GET['page'] - 1;
                $paginate['paginate']['current'] = $_GET['page'];
                $paginate['paginate']['next'] = $_GET['page'] + 1;
                $paginate['paginate']['offset'] = ($paginate['paginate']['current'] - 1) * $paginate['paginate']['max'];
            }
        }
        return $paginate;
    }
}