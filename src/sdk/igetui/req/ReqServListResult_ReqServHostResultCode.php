<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 2017/7/2
 * Time: 16:12
 */

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBEnum;

class ReqServListResult_ReqServHostResultCode extends PBEnum
{
    const successed = 0;
    const failed = 1;
    const busy = 2;
}