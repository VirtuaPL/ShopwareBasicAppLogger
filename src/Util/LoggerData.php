<?php

declare(strict_types=1);

namespace Virtua\ShopwareBasicAppLoggerBundle\Util;

class LoggerData extends LoggerDataAbstract
{
    public function __construct(
        ?string $channel = null,
        ?string $level = null,
        ?int $message = null
    ) {
        parent::__construct($channel, $level, $message);
    }
}
