<?php
namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBMessage;

class GtAuthResult extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = NULL) {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
    }

    function code() {
        return $this->_get_value("1");
    }

    function set_code($value) {
        return $this->_set_value("1", $value);
    }

    function redirectAddress() {
        return $this->_get_value("2");
    }

    function set_redirectAddress($value) {
        return $this->_set_value("2", $value);
    }

    function seqId() {
        return $this->_get_value("3");
    }

    function set_seqId($value) {
        return $this->_set_value("3", $value);
    }

    function info() {
        return $this->_get_value("4");
    }

    function set_info($value) {
        return $this->_set_value("4", $value);
    }
}