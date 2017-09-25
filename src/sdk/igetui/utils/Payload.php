<?php

namespace Cncal\Getui\Sdk\IGetui\Utils;

Class Payload
{
    var $APS = "aps";
    var $params;
    var $alert;
    var $badge;
    var $sound = "";

    var $alertBody;
    var $alertActionLocKey;
    var $alertLocKey;
    var $alertLocArgs;
    var $alertLaunchImage;
    var $contentAvailable;

    function getParams()
    {
        return $this->params;
    }

    function  setParams($params)
    {
        $this->params = $params;
    }

    function addParam($key, $obj)
    {
        if ($this->params == null) {
            $this->params = array();
        }

        if ($this->APS == strtolower($key)) {
            throw new \Exception("the key can't be aps");
        }

        $this->params[$key] = $obj;
    }

    function getAlert()
    {
        return $this->alert;
    }

    function setAlert($alert)
    {
        $this->alert = $alert;
    }

    function getBadge()
    {
        return $this->badge;
    }

    function setBadge($badge)
    {
        $this->badge = $badge;
    }

    function getSound()
    {
        return $this->sound;
    }

    function setSound($sound)
    {
        $this->sound = $sound;
    }

    function getAlertBody()
    {
        return $this->alertBody;
    }

    function setAlertBody($alertBody)
    {
        $this->alertBody = $alertBody;
    }

    function getAlertActionLocKey()
    {
        return $this->alertActionLocKey;
    }

    function setAlertActionLocKey($alertActionLocKey)
    {
        $this->alertActionLocKey = $alertActionLocKey;
    }

    function getAlertLocKey()
    {
        return $this->alertLocKey;
    }

    function  setAlertLocKey($alertLocKey)
    {
        $this->alertLocKey = $alertLocKey;
    }

    function getAlertLaunchImage()
    {
        return $this->alertLaunchImage;
    }

    function setAlertLaunchImage($alertLaunchImage)
    {
        $this->alertLaunchImage = $alertLaunchImage;
    }

    function getAlertLocArgs()
    {
        return $this->alertLocArgs;
    }

    function setAlertLocArgs($alertLocArgs)
    {
        $this->alertLocArgs = $alertLocArgs;
    }

    function getContentAvailable()
    {
        return $this->contentAvailable;
    }

    function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;
    }

    function putIntoJson($key, $value, $obj)
    {
        if ($value != null) {
            $obj[$key] = $value;
        }
        return $obj;
    }

    function toString()
    {
        $object = array();
        $apsObj = array();
        if ($this->getAlert() != null) {
            $apsObj["alert"] = urlencode($this->getAlert());
        } else {
            if ($this->getAlertBody() != null || $this->getAlertLocKey() != null) {
                $alertObj = array();
                $alertObj = $this->putIntoJson("body", ($this->getAlertBody()), $alertObj);
                $alertObj = $this->putIntoJson("action-loc-key", ($this->getAlertActionLocKey()), $alertObj);
                $alertObj = $this->putIntoJson("loc-key", ($this->getAlertLocKey()), $alertObj);
                $alertObj = $this->putIntoJson("launch-image", ($this->getAlertLaunchImage()), $alertObj);

                if ($this->getAlertLocArgs() != null) {
                    $array = array();
                    foreach ($this->getAlertLocArgs() as $str) {
                        array_push($array, ($str));
                    }
                    $alertObj["loc-args"] = $array;
                }

                $apsObj["alert"] = $alertObj;
            }
        }

        if ($this->getBadge() != null) {
            $apsObj["badge"] = $this->getBadge();
        }

        // 判断是否静音
        if ("com.gexin.ios.silence" != ($this->getSound())) {
            $apsObj = $this->putIntoJson("sound", ($this->getSound()), $apsObj);
        }

        if ($this->getContentAvailable() == 1) {
            $apsObj["content-available"]=1;
        }

        $object[$this->APS] = $apsObj;

        if ($this->getParams() != null) {
            foreach ($this->getParams() as $key => $value) {
                $object[($key)] = ($value);
            }
        }

        return Util::json_encode($object);
    }
}