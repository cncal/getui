<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 2017/7/2
 * Time: 18:40
 */

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\Type\PBEnum;

class ActionChain_Type extends PBEnum
{
    const refer = 0;
    const notification = 1;
    const popup = 2;
    const startapp = 3;
    const startweb = 4;
    const smsinbox = 5;
    const checkapp = 6;
    const eoa = 7;
    const appdownload = 8;
    const startsms = 9;
    const httpproxy = 10;
    const smsinbox2 = 11;
    const mmsinbox2 = 12;
    const popupweb = 13;
    const dial = 14;
    const reportbindapp = 15;
    const reportaddphoneinfo = 16;
    const reportapplist = 17;
    const terminatetask = 18;
    const reportapp = 19;
    const enablelog = 20;
    const disablelog = 21;
    const uploadlog = 22;
}