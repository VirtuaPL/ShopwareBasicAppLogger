<?php

namespace Virtua\ShopwareAppLoggerBundle\Entity;

use App\Entity\ShopwareShop;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Entity;

/**
 * @ORM\Entity(repositoryClass=ShopwareAppLogRepository::class)
 * @ORM\Table(name="shopware_app_log")
 */
class ShopwareAppLog extends ShopwareAppLogAbstract
{
}
