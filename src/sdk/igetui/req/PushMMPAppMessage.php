<?php

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBMessage;

class PushMMPAppMessage extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = NULL)
    {
        parent::__construct($reader);
        $this->fields["1"] = "MMPMessage";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = array();
        $this->fields["3"] = "PBString";
        $this->values["3"] = array();
        $this->fields["4"] = "PBString";
        $this->values["4"] = array();
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
    }

    function message()
    {
        return $this->_get_value("1");
    }

    function set_message($value)
    {
        return $this->_set_value("1", $value);
    }

    function appIdList($offset)
    {
        $v = $this->_get_arr_value("2", $offset);
        return $v->get_value();
    }

    function append_appIdList($value)
    {
        $v = $this->_add_arr_value("2");
        $v->set_value($value);
    }

    function set_appIdList($index, $value)
    {
        $v = new $this->fields["2"]();
        $v->set_value($value);
        $this->_set_arr_value("2", $index, $v);
    }

    function remove_last_appIdList()
    {
        $this->_remove_last_arr_value("2");
    }

    function appIdList_size()
    {
        return $this->_get_arr_size("2");
    }

    function phoneTypeList($offset)
    {
        $v = $this->_get_arr_value("3", $offset);
        return $v->get_value();
    }

    function append_phoneTypeList($value)
    {
        $v = $this->_add_arr_value("3");
        $v->set_value($value);
    }

    function set_phoneTypeList($index, $value)
    {
        $v = new $this->fields["3"]();
        $v->set_value($value);
        $this->_set_arr_value("3", $index, $v);
    }

    function remove_last_phoneTypeList()
    {
        $this->_remove_last_arr_value("3");
    }

    function phoneTypeList_size()
    {
        return $this->_get_arr_size("3");
    }

    function provinceList($offset)
    {
        $v = $this->_get_arr_value("4", $offset);
        return $v->get_value();
    }

    function append_provinceList($value)
    {
        $v = $this->_add_arr_value("4");
        $v->set_value($value);
    }

    function set_provinceList($index, $value)
    {
        $v = new $this->fields["4"]();
        $v->set_value($value);
        $this->_set_arr_value("4", $index, $v);
    }

    function remove_last_provinceList()
    {
        $this->_remove_last_arr_value("4");
    }

    function provinceList_size()
    {
        return $this->_get_arr_size("4");
    }

    function seqId()
    {
        return $this->_get_value("5");
    }

    function set_seqId($value)
    {
        return $this->_set_value("5", $value);
    }
}