<?php

declare(strict_types=1);

namespace Virtua\ShopwareBasicAppLoggerBundle\Service;

use Virtua\ShopwareBasicAppLoggerBundle\Util\LoggerDataAbstract;

abstract class LoggerAbstract
{
    public function log(LoggerDataAbstract $data)
    {
        //use your App/Core/Client->updateEntity($logData)
    }
}
