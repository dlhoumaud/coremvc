<?php
/**
 * @ Author: 
 * @ Create Time: 2025-02-27 09:16:53
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-06 16:55:41
 * @ Description: 
 */
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Error;
use App\Services\ConfigurationService;

class ConfigurationController extends Controller
{
    public function show()
    {
        $configuration = ConfigurationService::getAllConfiguration();
        if (isset($configuration['error'])) {
            Error::header($configuration['error']['code']);
            $data = [
                'head_title' => $configuration['error']['message'],
            ];
            self::view($configuration['error']['code'], $data);
            exit($configuration['error']['code']);
        }

        $pagination = ConfigurationService::paginate($configuration['articles_numbers_by_page']);

        $articles = ConfigurationService::articles(
                        $configuration['articles_numbers_by_page'], 
                        $pagination['paginate']['offset']
                    );


        $data = [
            'head_title' => $configuration['site_name'],
        ];
        self::view('configuration', array_merge($data, $configuration, $articles, $pagination));
    }
}