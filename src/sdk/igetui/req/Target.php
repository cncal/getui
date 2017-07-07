<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 2017/7/2
 * Time: 18:43
 */

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBMessage;

class Target extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = NULL) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
    }

    function appId() {
        return $this->_get_value("1");
    }

    function set_appId($value) {
        return $this->_set_value("1", $value);
    }

    function clientId() {
        return $this->_get_value("2");
    }

    function set_clientId($value) {
        return $this->_set_value("2", $value);
    }

    function alias() {
        return $this->_get_value("3");
    }

    function set_alias($value) {
        return $this->_set_value("3", $value);
    }
}