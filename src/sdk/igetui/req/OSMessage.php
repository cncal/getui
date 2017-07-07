<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 2017/7/2
 * Time: 18:42
 */

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBMessage;

class OSMessage extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = NULL) {
        parent::__construct($reader);
        $this->fields["2"] = "PBBool";
        $this->values["2"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
        $this->fields["4"] = "Transparent";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBInt";
        $this->values["6"] = "";
        $this->fields["7"] = "PBInt";
        $this->values["7"] = "";
        $this->fields["8"] = "PBInt";
        $this->values["8"] = "";
    }

    function isOffline() {
        return $this->_get_value("2");
    }

    function set_isOffline($value) {
        return $this->_set_value("2", $value);
    }

    function offlineExpireTime() {
        return $this->_get_value("3");
    }

    function set_offlineExpireTime($value) {
        return $this->_set_value("3", $value);
    }

    function transparent() {
        return $this->_get_value("4");
    }

    function set_transparent($value) {
        return $this->_set_value("4", $value);
    }

    function extraData() {
        return $this->_get_value("5");
    }

    function set_extraData($value) {
        return $this->_set_value("5", $value);
    }

    function msgType() {
        return $this->_get_value("6");
    }

    function set_msgType($value) {
        return $this->_set_value("6", $value);
    }

    function msgTraceFlag() {
        return $this->_get_value("7");
    }

    function set_msgTraceFlag($value) {
        return $this->_set_value("7", $value);
    }

    function priority() {
        return $this->_get_value("8");
    }

    function set_priority($value) {
        return $this->_set_value("8", $value);
    }
}