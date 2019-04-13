<?php

declare(strict_types=1);

namespace App\Model\Event\Command\Handler;

use App\Model\Event\Command\ModifyEventCommand;
use App\Model\Event\EventInterface;
use App\Model\Event\EventRepositoryInterface;
use App\Model\Event\Exception\EventNotFoundException;

class ModifyEventCommandHandler
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(ModifyEventCommand $command): EventInterface
    {
        $event = $this->eventRepository->findById($command->getId());
        if (!$event) {
            throw new EventNotFoundException($command->getId());
        }

        $event->setTitle($command->getTitle())
            ->setDescription($command->getDescription())
            ->setDate($command->getDate());

        return $event;
    }
}
