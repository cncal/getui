<?php
namespace Cncal\Getui\Sdk\IGetui\Utils;

class LogUtils
{
    static $debug = true;
    public static function debug($log)
    {
        if (self::$debug) {
            echo date('y-m-d h:i:s',time()).($log) . "\r\n";
        }
    }
}