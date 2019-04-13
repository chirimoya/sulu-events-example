<?php

declare(strict_types=1);

namespace App\Model\Event\Query\Handler;

use App\Model\Event\EventInterface;
use App\Model\Event\EventRepositoryInterface;
use App\Model\Event\Exception\EventNotFoundException;
use App\Model\Event\Query\FindEventQuery;

class FindEventQueryHandler
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(FindEventQuery $query): EventInterface
    {
        $event = $this->eventRepository->findById($query->getId());

        if (!$event) {
            throw new EventNotFoundException($query->getId());
        }

        return $event;
    }
}
