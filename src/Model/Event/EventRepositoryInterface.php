<?php

declare(strict_types=1);

namespace App\Model\Event;

interface EventRepositoryInterface
{
    public function create(string $id): EventInterface;

    public function findById(string $id): ?EventInterface;

    public function remove(EventInterface $event): void;
}
