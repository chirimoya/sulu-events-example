<?php

declare(strict_types=1);

namespace App\Model\Event\Exception;

class EventNotFoundException extends \Exception
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        parent::__construct(sprintf('Event with if "%s" not found', $id));

        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
