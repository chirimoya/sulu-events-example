<?php

declare(strict_types=1);

namespace App\Model\Event\Query;

class ListEventsQuery
{
    /**
     * @var array
     */
    private $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
