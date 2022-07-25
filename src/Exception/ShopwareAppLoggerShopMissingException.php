<?php

declare(strict_types=1);

namespace Virtua\ShopwareBasicAppLoggerBundle\Exception;

class ShopwareAppLoggerShopMissingException extends \Exception
{
    public function __construct(string $shopId)
    {
        $message = sprintf('Shopware shop \'%s\' not found', $shopId);
        parent::__construct($message, 0, null);
    }
}
