<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 2017/7/2
 * Time: 19:12
 */

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBMessage;

class PushListMessage extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = NULL) {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "Target";
        $this->values["3"] = array();
    }

    function seqId() {
        return $this->_get_value("1");
    }

    function set_seqId($value) {
        return $this->_set_value("1", $value);
    }

    function taskId() {
        return $this->_get_value("2");
    }

    function set_taskId($value) {
        return $this->_set_value("2", $value);
    }

    function targets($offset) {
        return $this->_get_arr_value("3", $offset);
    }

    function add_targets() {
        return $this->_add_arr_value("3");
    }

    function set_targets($index, $value) {
        $this->_set_arr_value("3", $index, $value);
    }

    function remove_last_targets() {
        $this->_remove_last_arr_value("3");
    }

    function targets_size() {
        return $this->_get_arr_size("3");
    }
}