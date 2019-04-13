<?php

declare(strict_types=1);

namespace App\Model\Event\Command\Handler;

use App\Model\Event\Command\CreateEventCommand;
use App\Model\Event\EventInterface;
use App\Model\Event\EventRepositoryInterface;

class CreateEventCommandHandler
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(CreateEventCommand $command): EventInterface
    {
        $event = $this->eventRepository->create($command->getId());
        $event->setTitle($command->getTitle())
            ->setDescription($command->getDescription())
            ->setDate($command->getDate());

        return $event;
    }
}
