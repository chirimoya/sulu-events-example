<?php

declare(strict_types=1);

namespace App\Model\Event\Command;

use App\Common\Payload\PayloadTrait;

class ModifyEventCommand
{
    use PayloadTrait {
        __construct as protected initializePayloadTrait;
    }

    /**
     * @var string
     */
    private $id;

    public function __construct(string $id, array $payload)
    {
        $this->id = $id;

        $this->initializePayloadTrait($payload);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->getStringValue('title');
    }

    public function getDescription(): string
    {
        return $this->getNullableStringValue('description') ?? '';
    }

    public function getDate(): ?\DateTime
    {
        return $this->getNullableDateTimeValue('date');
    }
}
