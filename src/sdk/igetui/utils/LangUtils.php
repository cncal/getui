<?php

namespace Cncal\Getui\Sdk\IGetui\Utils;

class LangUtils
{
    private static $REGEX = '/^(?:(?!0000)[0-9]{4}(?:(?:0[1-9]|1[0-2])(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])(?:29|30)|(?:0[13578]|1[02])31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)0229)$/i';

    public static function validateDate($date)
    {
        if ($date == null) {
            return false;
        }

        if (!preg_match(LangUtils::$REGEX, $date)) {
            return false;
        }

        return strtotime($date) < time();
    }
}