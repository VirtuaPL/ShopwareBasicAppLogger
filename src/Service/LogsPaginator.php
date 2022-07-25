<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Service;

use App\Repository\ImojeLogRepository;
use App\Repository\ShopwareShopRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Virtua\ShopwareAppLoggerBundle\Exception\ShopwareAppLoggerShopMissingException;
use Virtua\ShopwareAppLoggerBundle\Util\PaginationData;

class LogsPaginator
{
    public const PAGE_LIMIT = 10;
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
     * @return array<string, mixed>
     * @throws ShopwareAppLoggerShopMissingException
     */
    public function getPaginatedLogs(string $shopId, int $page = 1, string $order = 'DESC'): array
    {
        $shop = $this->shopRepository->findByShopId($shopId);

        if (!$shop) {
            throw new ShopwareAppLoggerShopMissingException($shopId);
        }

        if ($order != 'ASC') {
            $order = 'DESC';
        }

        $logsCount = $this->logRepository->count(['shopwareShop' => $shop]);

        $pagination = new PaginationData();

        if ($logsCount < 1) {
            return [
                'logs' => [],
                'pagination' => $pagination
            ];
        }

        $maxPage = (int) ceil($logsCount / self::PAGE_LIMIT);

        if ($maxPage < 1) {
            $maxPage = 1;
        }

        if ($page > $maxPage || $page < 0) {
            $page = $maxPage;
        }

        $offset = ($page - 1) * self::PAGE_LIMIT;

        $logs = $this->logRepository->findBy(['shopwareShop' => $shop], ['id' => $order], self::PAGE_LIMIT, $offset);

        $pagination->setPage($page);
        $pagination->setMaxPage($maxPage);

        return [
            'logs' => $logs,
            'pagination' => $pagination
        ];
    }
}
