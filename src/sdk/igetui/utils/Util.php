<?php

namespace Cncal\Getui\Sdk\IGetui\Utils;

class Util
{
    static function json_encode($input)
    {
        // 从 PHP 5.4.0 起, 增加了这个选项.
        if (defined('JSON_UNESCAPED_UNICODE')) {
            return json_encode($input, JSON_UNESCAPED_UNICODE);
        }

        if (is_string($input)) {
            $text = $input;
            $text = str_replace("\\", "\\\\", $text);
            //$text = str_replace('/', "\\/",   $text);
            $text = str_replace('"', "\\" . '"', $text);
            $text = str_replace("\b", "\\b", $text);
            $text = str_replace("\t", "\\t", $text);
            $text = str_replace("\n", "\\n", $text);
            $text = str_replace("\f", "\\f", $text);
            $text = str_replace("\r", "\\r", $text);
            //$text = str_replace("\u", "\\u", $text);
            return '"' . $text . '"';
        } elseif (is_array($input) || is_object($input)) {
            $arr = array();
            $is_obj = is_object($input) || (array_keys($input) !== range(0, count($input) - 1));

            foreach ($input as $k => $v) {
                if ($is_obj) {
                    $arr[] = self::json_encode($k) . ':' . self::json_encode($v);
                } else {
                    $arr[] = self::json_encode($v);
                }
            }

            if ($is_obj) {
                return '{' . join(',', $arr) . '}';
            } else {
                return '[' . join(',', $arr) . ']';
            }
        } else {
            return $input . '';
        }
    }
}