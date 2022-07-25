<?php

namespace Virtua\ShopwareAppLoggerBundle\Entity;

use App\Entity\ShopwareShop;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass=ShopwareAppLogRepository::class)
 * @ORM\Table(name="shopware_app_log")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entity_name", type="string")
 */
abstract class ShopwareAppLogAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity=ShopwareShop::class, inversedBy="logs")
     * @ORM\JoinColumn(nullable=false)
     */
    protected ShopwareShop $shopwareShop;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $errorCode;

    /**
     * @ORM\Column(type="text")
     */
    protected string $errorMessage;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    protected \DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopwareShop(): ?ShopwareShop
    {
        return $this->shopwareShop;
    }

    public function setShopwareShop(?ShopwareShop $shopwareShop): self
    {
        $this->shopwareShop = $shopwareShop;

        return $this;
    }

    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    public function setErrorCode(int $errorCode): self
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
