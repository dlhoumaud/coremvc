<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:34:14
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-30 15:28:21
 * @ Description: classe de log
 */
namespace App\Helpers;

class Log {

    static private function write($name='coremvc', $message) {
        $date=date("d-m-Y H:i:s");
        file_put_contents('../storage/logs/'.$name.'.log', $date."\t".$message."\n", FILE_APPEND);
    }

    static public function standard($message, $filename='coremvc') {
        self::write($filename, $message);
    }

    static public function error($message, $filename='coremvc') {
        self::write($filename.'.error', $message);
    }

    static public function e($message, $filename='coremvc') {
        self::error($message, $filename);
    }

    static public function warning($message, $filename='coremvc') {
        self::write($filename.'.warning', $message);
    }

    static public function w($message, $filename='coremvc') {
        self::warning($message, $filename);
    }

    static public function debug($message, $filename='coremvc') {
        self::write($filename.'.debug', $message);
    }

    static public function d($message, $filename='coremvc') {
        self::debug($message, $filename);
    }

}