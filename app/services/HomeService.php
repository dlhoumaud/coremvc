<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-28 11:13:39
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-28 11:38:27
 * @ Description:
 */

namespace App\Services;

class HomeService
{
    static public function getVueComponents() {
        return inject('js/components/carousel/indicators.js')
              .inject('js/components/carousel/item.js')
              .inject('js/components/card/img-top.js');
    }
}