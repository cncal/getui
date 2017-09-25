<?php

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBMessage;

class ReqServListResult extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = NULL)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = array();
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
    }

    function code()
    {
        return $this->_get_value("1");
    }

    function set_code($value)
    {
        return $this->_set_value("1", $value);
    }

    function host($offset)
    {
        $v = $this->_get_arr_value("2", $offset);
        return $v->get_value();
    }

    function append_host($value)
    {
        $v = $this->_add_arr_value("2");
        $v->set_value($value);
    }

    function set_host($index, $value)
    {
        $v = new $this->fields["2"]();
        $v->set_value($value);
        $this->_set_arr_value("2", $index, $v);
    }

    function remove_last_host()
    {
        $this->_remove_last_arr_value("2");
    }

    function host_size()
    {
        return $this->_get_arr_size("2");
    }

    function seqId()
    {
        return $this->_get_value("3");
    }

    function set_seqId($value)
    {
        return $this->_set_value("3", $value);
    }
}