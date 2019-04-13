<?php

declare(strict_types=1);

namespace App\Model\Event\Command\Handler;

use App\Model\Event\Command\RemoveEventCommand;
use App\Model\Event\EventRepositoryInterface;
use App\Model\Event\Exception\EventNotFoundException;

class RemoveEventCommandHandler
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(RemoveEventCommand $command): void
    {
        $event = $this->eventRepository->findById($command->getId());
        if (!$event) {
            throw new EventNotFoundException($command->getId());
        }

        $this->eventRepository->remove($event);
    }
}
