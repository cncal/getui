<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 2017/7/2
 * Time: 16:14
 */

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\Type\PBEnum;

class PushResult_EPushResult extends PBEnum
{
    const successed_online = 0;
    const successed_offline = 1;
    const successed_ignore = 2;
    const failed = 3;
    const busy = 4;
    const success_startBatch = 5;
    const success_endBatch = 6;
}