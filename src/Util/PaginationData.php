<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Util;

class PaginationData
{
    private int $page;
    private int $maxPage;

    public function __construct()
    {
        $this->page = 1;
        $this->maxPage = 1;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function getMaxPage(): int
    {
        return $this->maxPage;
    }

    public function setMaxPage(int $maxPage): void
    {
        $this->maxPage = $maxPage;
    }
}
