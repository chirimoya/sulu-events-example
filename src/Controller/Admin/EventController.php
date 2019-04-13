<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Event\Command\CreateEventCommand;
use App\Model\Event\Command\ModifyEventCommand;
use App\Model\Event\Command\RemoveEventCommand;
use App\Model\Event\Query\FindEventQuery;
use App\Model\Event\Query\ListEventsQuery;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class EventController implements ClassResourceInterface
{
    use ControllerTrait;
    use HandleTrait {
        handle as dispatch;
    }

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus, ViewHandlerInterface $viewHandler)
    {
        $this->messageBus = $messageBus;

        $this->setViewHandler($viewHandler);
    }

    public function cgetAction(Request $request): Response
    {
        return $this->handleView(
            $this->view($this->dispatch(new ListEventsQuery($request->query->all())))
        );
    }

    public function getAction(string $id): Response
    {
        return $this->handleView(
            $this->view($this->dispatch(new FindEventQuery($id)))
        );
    }

    public function postAction(Request $request): Response
    {
        return $this->handleView(
            $this->view($this->dispatch(new CreateEventCommand($request->request->all())), Response::HTTP_CREATED)
        );
    }

    public function putAction(string $id, Request $request): Response
    {
        return $this->handleView(
            $this->view($this->dispatch(new ModifyEventCommand($id, $request->request->all())))
        );
    }

    public function deleteAction(string $id): Response
    {
        return $this->handleView(
            $this->view($this->dispatch(new RemoveEventCommand($id)), Response::HTTP_NO_CONTENT)
        );
    }
}
