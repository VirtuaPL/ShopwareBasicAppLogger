<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Service;

use App\Repository\ShopwareShopRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Virtua\ShopwareAppLoggerBundle\Entity\ShopwareAppLog;
use Virtua\ShopwareAppLoggerBundle\Util\LoggerDataAbstract;

abstract class LoggerAbstract
{
    private ServiceEntityRepository $logRepository;
    private ServiceEntityRepository $shopRepository;

    public function __construct(
        ServiceEntityRepository $logRepository,
        ServiceEntityRepository $shopRepository
    ) {
        $this->logRepository = $logRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function log(LoggerDataAbstract $data): void
    {
        $shopEntity = $this->shopRepository->findByShopId($data->getShopId());

        if (!$shopEntity) {
            return;
        }

        $logEntity = new ShopwareAppLog();
        $logEntity->setShopwareShop($shopEntity);
        $logEntity->setErrorCode($data->getErrorCode());
        $logEntity->setErrorMessage($data->getErrorMessage());
        $logEntity->setCreatedAt(new \DateTimeImmutable());

        $this->logRepository->add($logEntity, true);
    }
}
