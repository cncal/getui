<?php

namespace Cncal\Getui\Sdk\IGetui\Req;

use Cncal\Getui\Sdk\Protobuf\Type\PBEnum;

class ActionChain_SMSStatus extends PBEnum
{
    const unread = 0;
    const read = 1;
}