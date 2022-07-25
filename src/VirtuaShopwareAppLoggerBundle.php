<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Virtua\ShopwareAppLoggerBundle\DependencyInjection\ShopwareAppLogExtension;

class VirtuaShopwareAppLoggerBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new ShopwareAppLogExtension();
    }
}
