<?php

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\PBEnum;

class ReqServListResult_ReqServHostResultCode extends PBEnum
{
    const successed = 0;
    const failed = 1;
    const busy = 2;
}