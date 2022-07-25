<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Service;

use App\Repository\ShopwareShopRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Virtua\ShopwareAppLoggerBundle\Exception\ShopwareAppLoggerShopMissingException;

abstract class LogsCleanerAbstract
{
    private ServiceEntityRepository $logRepository;
    private ShopwareShopRepository $shopRepository;

    public function __construct(
        ServiceEntityRepository $logRepository,
        ShopwareShopRepository $shopRepository
    ) {
        $this->logRepository = $logRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * @throws ShopwareAppLoggerShopMissingException
     */
    public function cleanAllLogs(string $shopId): void
    {
        $this->cleanLogs($shopId);
    }

    /**
     * @throws ShopwareAppLoggerShopMissingException
     */
    public function cleanOldLogs(): void
    {
        $dateTo = new \DateTimeImmutable();
        // Subtract 1 month from current date
        $dateTo = $dateTo->sub(new \DateInterval('P1M'));
        $this->cleanLogs(null, null, $dateTo);
    }

    /**
     * @throws ShopwareAppLoggerShopMissingException
     */
    protected function cleanLogs(
        ?string $shopId = null,
        ?\DateTimeImmutable $dateFrom = null,
        ?\DateTimeImmutable $dateTo = null
    ): void {
        $shop = null;

        if ($shopId) {
            $shop = $this->shopRepository->findByShopId($shopId);
        }

        if (!$shop && $shopId) {
            throw new ShopwareAppLoggerShopMissingException($shopId);
        }

        $parameters = [];

        $queryBuilder = $this->logRepository->createQueryBuilder('l');
        $queryBuilder->delete();

        if ($shop) {
            $queryBuilder->andWhere('l.shopwareShop = :shopId');
            $parameters['shopId'] = $shop->getId();
        }

        if ($dateTo) {
            $queryBuilder->andWhere('l.createdAt <= :dateTo');
            $parameters['dateTo'] = $dateTo;
        }

        if ($dateFrom) {
            $queryBuilder->andWhere('l.createdAt >= :dateFrom');
            $parameters['dateFrom'] = $dateFrom;
        }

        $queryBuilder->setParameters($parameters);
        $queryBuilder->getQuery()->execute();
    }
}
