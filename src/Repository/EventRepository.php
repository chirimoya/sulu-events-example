<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Event\Event;
use App\Model\Event\EventInterface;
use App\Model\Event\EventRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EventRepository extends ServiceEntityRepository implements EventRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function create(string $id): EventInterface
    {
        $class = $this->getEntityName();

        /** @var EventInterface $event */
        $event = new $class($id);

        $this->getEntityManager()->persist($event);

        return $event;
    }

    public function findById(string $id): ?EventInterface
    {
        /** @var EventInterface|null $event */
        $event = $this->findOneBy(['id' => $id]);

        return $event;
    }

    public function remove(EventInterface $event): void
    {
        $this->getEntityManager()->remove($event);
    }
}
