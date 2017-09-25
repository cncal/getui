<?php

namespace Cncal\Getui\Sdk\IGetui\Utils;

Class ApnsUtils
{
    static function validatePayloadLength($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload,$contentAvailable)
    {
        $json = ApnsUtils :: processPayload($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload,$contentAvailable);
        return strlen($json);
    }

    static function processPayload($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload, $contentAvailable)
    {
        $isValid = false;
        $pb = new Payload();
        if ($locKey != null && strlen($locKey) > 0) {
            // loc-key
            $pb->setAlertLocKey(($locKey));
            // loc-args
            if ($locArgs != null && strlen($locArgs) > 0) {
                $pb->setAlertLocArgs(explode(',',($locArgs)));
            }

            $isValid = true;
        }

        // body
        if ($message != null && strlen($message) > 0) {
            $pb->setAlertBody(($message));
            $isValid = true;
        }

        // action-loc-key
        if ($actionLocKey!=null && strlen($actionLocKey) > 0) {
            $pb->setAlertActionLocKey($actionLocKey);
        }

        // launch-image
        if ($launchImage!=null && strlen($launchImage) > 0) {
            $pb->setAlertLaunchImage($launchImage);
        }

        // badge
        $badgeNum = -1;
        if (is_numeric($badge)) {
            $badgeNum = (int)$badge;
        }

        if ($badgeNum >= 0) {
            $pb->setBadge($badgeNum);
            $isValid = true;
        }

        // sound
        if ($sound != null && strlen($sound) > 0) {
            $pb->setSound($sound);
        } else {
            $pb->setSound("default");
        }

        //contentAvailable
        if ($contentAvailable == 1) {
            $pb->setContentAvailable(1);
            $isValid = true;
        }

        // payload
        if ($payload != null && strlen($payload) > 0) {
            $pb->addParam("payload", ($payload));
        }

        if ($isValid == false) {
            throw new \Exception("one of the params(locKey,message,badge) must not be null or contentAvailable must be 1");
        }

        $json = $pb->toString();

        if ($json == null) {
            throw new \Exception("payload json is null");
        }

        return $json;
    }
}