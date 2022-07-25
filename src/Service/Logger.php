<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Service;

use App\Repository\ShopwareShopRepository;
use Virtua\ShopwareAppLoggerBundle\Repository\ShopwareAppLogRepository;

class Logger extends  LoggerAbstract
{
    private ShopwareAppLogRepository $logRepository;
    private ShopwareShopRepository $shopRepository;

    public function __construct(
        ShopwareAppLogRepository $logRepository,
        ShopwareShopRepository $shopRepository
    ) {
        parent::__construct($logRepository, $shopRepository);
    }
}
