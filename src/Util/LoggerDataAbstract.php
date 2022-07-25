<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Util;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response;

abstract class LoggerDataAbstract
{
    /**
     * @var string
     */
    protected string $channel;

    /**
     * @var int
     */
    protected int $level;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var string
     */
    protected string $shopId;

    /**
     * @var array|null
     */
    protected ?array $context;

    /**
     * LoggerDataAbstract constructor.
     * @param string $shopId
     * @param string|null $channel
     * @param int|null $level
     * @param string|null $message
     * @param array|null $context
     */
    public function __construct(
        string $shopId,
        ?string $channel = null,
        ?int $level = null,
        ?string $message = null,
        ?array $context = null
    )
    {
        $this->shopId = $shopId;
        $this->channel = $channel ?? 'Application';
        $this->level = $level ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        $this->message = $message ?? 'Something went wrong.';
        $this->context = $message;
    }

    /**
     * @return array <int,string>
     */
    #[ArrayShape(['shopId' => "string", 'channel' => "string", 'level' => "int", 'message' => "string"])]
    public function toArray(): array
    {
        return [
            'channel' => $this->channel,
            'level' => $this->level,
            'message' => $this->message,
            'context' => $this->context,
        ];
    }

    /**
     * @return array|null
     */
    public function getContext(): array|null
    {
        return $this->context;
    }

    /**
     * @param string|null $appMessage
     * @param array|null $appData
     */
    public function setContext(?string $appMessage, ?array $appData = null): void
    {
        $this->context = [
            'source' => 'shopware App',
            'additionalData' => [
                'message' => $appMessage,
                'appData' => $appData
            ]
        ];
    }


    /**
     * @return string
     */
    public function getShopId(): string
    {
        return $this->shopId;
    }

    /**
     * @param string $shopId
     */
    public function setShopId(string $shopId): void
    {
        $this->shopId = $shopId;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     */
    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
