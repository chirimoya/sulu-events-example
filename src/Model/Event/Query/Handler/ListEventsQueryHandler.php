<?php

declare(strict_types=1);

namespace App\Model\Event\Query\Handler;

use App\Common\Handler\ListQueryHandler;
use App\Model\Event\Event;
use App\Model\Event\Query\ListEventsQuery;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;

class ListEventsQueryHandler extends ListQueryHandler
{

    const ROUTE = 'app.get_events';

    public function __invoke(ListEventsQuery $query): ListRepresentation
    {
        return $this->createListRepresentation(
            Event::class,
            Event::LIST_KEY,
            Event::RESOURCE_KEY,
            $query->getQuery(),
            self::ROUTE
        );
    }
}
