<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-28 11:13:39
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-16 11:13:20
 * @ Description:
 */

namespace App\Services;

class HomeService
{
    static public function getVueComponents() {
        return [
            'carousel/indicators.min',
            'carousel/items.min',
            'card/img-top.min',
            'hello-coremvc.min',
        ];
    }
}