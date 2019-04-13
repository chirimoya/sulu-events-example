<?php

declare(strict_types=1);

namespace App\Model\Event\Command;

use Ramsey\Uuid\Uuid;
use App\Common\Payload\PayloadTrait;

class CreateEventCommand
{
    use PayloadTrait {
        __construct as protected initializePayloadTrait;
    }

    /**
     * @var string
     */
    private $id;

    public function __construct(array $payload)
    {
        $this->id = Uuid::uuid4()->toString();

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
