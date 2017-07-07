<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 2017/7/3
 * Time: 16:40
 */

namespace Cncal\Getui\Sdk\IGetui\Msg;

class SimpleAlertMsg implements ApnMsg
{
    var $alertMsg;

    public function get_alertMsg()
    {
        return $this->alertMsg;
    }
}