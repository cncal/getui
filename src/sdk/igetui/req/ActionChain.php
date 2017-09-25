<?php

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBMessage;
use Cncal\Getui\Sdk\Protobuf\Type\PBBool;

class ActionChain extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = NULL)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "ActionChain_Type";
        $this->values["2"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
        $this->fields["100"] = "PBString";
        $this->values["100"] = "";
        $this->fields["101"] = "PBString";
        $this->values["101"] = "";
        $this->fields["102"] = "PBString";
        $this->values["102"] = "";
        $this->fields["103"] = "PBString";
        $this->values["103"] = "";
        $this->fields["104"] = "PBBool";
        $this->values["104"] = "";
        $this->fields["105"] = "PBBool";
        $this->values["105"] = "";
        $this->fields["106"] = "PBBool";
        $this->values["106"] = "";
        $this->fields["107"] = "PBString";
        $this->values["107"] = "";
        $this->fields["120"] = "PBString";
        $this->values["120"] = "";
        $this->fields["121"] = "Button";
        $this->values["121"] = array();
        $this->fields["140"] = "PBString";
        $this->values["140"] = "";
        $this->fields["141"] = "AppStartUp";
        $this->values["141"] = "";
        $this->fields["142"] = "PBBool";
        $this->values["142"] = "";
        $this->fields["143"] = "PBInt";
        $this->values["143"] = "";
        $this->fields["160"] = "PBString";
        $this->values["160"] = "";
        $this->fields["161"] = "PBString";
        $this->values["161"] = "";
        $this->fields["162"] = "PBBool";
        $this->values["162"] = "";
        $this->values["162"] = new PBBool();
        $this->values["162"]->value = FALSE;
        $this->fields["180"] = "PBString";
        $this->values["180"] = "";
        $this->fields["181"] = "PBString";
        $this->values["181"] = "";
        $this->fields["182"] = "PBInt";
        $this->values["182"] = "";
        $this->fields["183"] = "ActionChain_SMSStatus";
        $this->values["183"] = "";
        $this->fields["200"] = "PBInt";
        $this->values["200"] = "";
        $this->fields["201"] = "PBInt";
        $this->values["201"] = "";
        $this->fields["220"] = "PBString";
        $this->values["220"] = "";
        $this->fields["223"] = "PBBool";
        $this->values["223"] = "";
        $this->fields["225"] = "PBBool";
        $this->values["225"] = "";
        $this->fields["226"] = "PBBool";
        $this->values["226"] = "";
        $this->fields["227"] = "PBBool";
        $this->values["227"] = "";
        $this->fields["241"] = "PBString";
        $this->values["241"] = "";
        $this->fields["242"] = "PBString";
        $this->values["242"] = "";
        $this->fields["260"] = "PBBool";
        $this->values["260"] = "";
        $this->fields["280"] = "PBString";
        $this->values["280"] = "";
        $this->fields["281"] = "PBString";
        $this->values["281"] = "";
        $this->fields["300"] = "PBBool";
        $this->values["300"] = "";
        $this->fields["320"] = "PBString";
        $this->values["320"] = "";
        $this->fields["340"] = "PBInt";
        $this->values["340"] = "";
        $this->fields["360"] = "PBString";
        $this->values["360"] = "";
        $this->fields["380"] = "PBString";
        $this->values["380"] = "";
        $this->fields["381"] = "InnerFiled";
        $this->values["381"] = array();
    }

    function actionId()
    {
        return $this->_get_value("1");
    }

    function set_actionId($value)
    {
        return $this->_set_value("1", $value);
    }

    function type()
    {
        return $this->_get_value("2");
    }

    function set_type($value)
    {
        return $this->_set_value("2", $value);
    }

    function next()
    {
        return $this->_get_value("3");
    }

    function set_next($value)
    {
        return $this->_set_value("3", $value);
    }

    function logo()
    {
        return $this->_get_value("100");
    }

    function set_logo($value)
    {
        return $this->_set_value("100", $value);
    }

    function logoURL()
    {
        return $this->_get_value("101");
    }

    function set_logoURL($value)
    {
        return $this->_set_value("101", $value);
    }

    function title()
    {
        return $this->_get_value("102");
    }

    function set_title($value)
    {
        return $this->_set_value("102", $value);
    }

    function text()
    {
        return $this->_get_value("103");
    }

    function set_text($value)
    {
        return $this->_set_value("103", $value);
    }

    function clearable()
    {
        return $this->_get_value("104");
    }

    function set_clearable($value)
    {
        return $this->_set_value("104", $value);
    }

    function ring()
    {
        return $this->_get_value("105");
    }

    function set_ring($value)
    {
        return $this->_set_value("105", $value);
    }

    function buzz()
    {
        return $this->_get_value("106");
    }

    function set_buzz($value)
    {
        return $this->_set_value("106", $value);
    }

    function bannerURL()
    {
        return $this->_get_value("107");
    }

    function set_bannerURL($value)
    {
        return $this->_set_value("107", $value);
    }

    function img()
    {
        return $this->_get_value("120");
    }

    function set_img($value)
    {
        return $this->_set_value("120", $value);
    }

    function buttons($offset)
    {
        return $this->_get_arr_value("121", $offset);
    }

    function add_buttons()
    {
        return $this->_add_arr_value("121");
    }

    function set_buttons($index, $value)
    {
        $this->_set_arr_value("121", $index, $value);
    }

    function remove_last_buttons()
    {
        $this->_remove_last_arr_value("121");
    }

    function buttons_size()
    {
        return $this->_get_arr_size("121");
    }

    function appid()
    {
        return $this->_get_value("140");
    }

    function set_appid($value)
    {
        return $this->_set_value("140", $value);
    }

    function appstartupid()
    {
        return $this->_get_value("141");
    }

    function set_appstartupid($value)
    {
        return $this->_set_value("141", $value);
    }

    function autostart()
    {
        return $this->_get_value("142");
    }

    function set_autostart($value)
    {
        return $this->_set_value("142", $value);
    }

    function failedAction()
    {
        return $this->_get_value("143");
    }

    function set_failedAction($value)
    {
        return $this->_set_value("143", $value);
    }

    function url()
    {
        return $this->_get_value("160");
    }

    function set_url($value)
    {
        return $this->_set_value("160", $value);
    }

    function withcid()
    {
        return $this->_get_value("161");
    }

    function set_withcid($value)
    {
        return $this->_set_value("161", $value);
    }

    function is_withnettype()
    {
        return $this->_get_value("162");
    }

    function set_is_withnettype($value)
    {
        return $this->_set_value("162", $value);
    }

    function address()
    {
        return $this->_get_value("180");
    }

    function set_address($value)
    {
        return $this->_set_value("180", $value);
    }

    function content()
    {
        return $this->_get_value("181");
    }

    function set_content($value)
    {
        return $this->_set_value("181", $value);
    }

    function ct()
    {
        return $this->_get_value("182");
    }

    function set_ct($value)
    {
        return $this->_set_value("182", $value);
    }

    function flag()
    {
        return $this->_get_value("183");
    }

    function set_flag($value)
    {
        return $this->_set_value("183", $value);
    }

    function successedAction()
    {
        return $this->_get_value("200");
    }

    function set_successedAction($value)
    {
        return $this->_set_value("200", $value);
    }

    function uninstalledAction()
    {
        return $this->_get_value("201");
    }

    function set_uninstalledAction($value)
    {
        return $this->_set_value("201", $value);
    }

    function name()
    {
        return $this->_get_value("220");
    }

    function set_name($value)
    {
        return $this->_set_value("220", $value);
    }

    function autoInstall()
    {
        return $this->_get_value("223");
    }

    function set_autoInstall($value)
    {
        return $this->_set_value("223", $value);
    }

    function wifiAutodownload()
    {
        return $this->_get_value("225");
    }

    function set_wifiAutodownload($value)
    {
        return $this->_set_value("225", $value);
    }

    function forceDownload()
    {
        return $this->_get_value("226");
    }

    function set_forceDownload($value)
    {
        return $this->_set_value("226", $value);
    }

    function showProgress()
    {
        return $this->_get_value("227");
    }

    function set_showProgress($value)
    {
        return $this->_set_value("227", $value);
    }

    function post()
    {
        return $this->_get_value("241");
    }

    function set_post($value)
    {
        return $this->_set_value("241", $value);
    }

    function headers()
    {
        return $this->_get_value("242");
    }

    function set_headers($value)
    {
        return $this->_set_value("242", $value);
    }

    function groupable()
    {
        return $this->_get_value("260");
    }

    function set_groupable($value)
    {
        return $this->_set_value("260", $value);
    }

    function mmsTitle()
    {
        return $this->_get_value("280");
    }

    function set_mmsTitle($value)
    {
        return $this->_set_value("280", $value);
    }

    function mmsURL()
    {
        return $this->_get_value("281");
    }

    function set_mmsURL($value)
    {
        return $this->_set_value("281", $value);
    }

    function preload()
    {
        return $this->_get_value("300");
    }

    function set_preload($value)
    {
        return $this->_set_value("300", $value);
    }

    function taskid()
    {
        return $this->_get_value("320");
    }

    function set_taskid($value)
    {
        return $this->_set_value("320", $value);
    }

    function duration()
    {
        return $this->_get_value("340");
    }

    function set_duration($value)
    {
        return $this->_set_value("340", $value);
    }

    function date()
    {
        return $this->_get_value("360");
    }

    function set_date($value)
    {
        return $this->_set_value("360", $value);
    }

    function stype()
    {
        return $this->_get_value("380");
    }

    function set_stype($value)
    {
        return $this->_set_value("380", $value);
    }

    function field($offset)
    {
        return $this->_get_arr_value("381", $offset);
    }

    function add_field()
    {
        return $this->_add_arr_value("381");
    }

    function set_field($index, $value)
    {
        $this->_set_arr_value("381", $index, $value);
    }

    function remove_last_field()
    {
        $this->_remove_last_arr_value("381");
    }

    function field_size()
    {
        return $this->_get_arr_size("381");
    }
}