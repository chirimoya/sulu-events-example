<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilder;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DoctrineListBuilderFactoryInterface
     */
    private $listBuilderFactory;
    /**
     * @var RestHelperInterface
     */
    private $restHelper;
    /**
     * @var FieldDescriptorFactoryInterface
     */
    private $fieldDescriptorsFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        DoctrineListBuilderFactoryInterface $listBuilderFactory,
        RestHelperInterface $restHelper,
        ?FieldDescriptorFactoryInterface $fieldDescriptorsFactory
    ) {
        $this->entityManager = $entityManager;
        $this->listBuilderFactory = $listBuilderFactory;
        $this->restHelper = $restHelper;

        if (!$fieldDescriptorsFactory) {
            throw new \RuntimeException(
                'FieldDescriptorFactory cannot be null - possible call within the website context.'
            );
        }
        $this->fieldDescriptorsFactory = $fieldDescriptorsFactory;
    }

    public function getEventsAction(Request $request): Response
    {
        $fieldDescriptors = $this->fieldDescriptorsFactory->getFieldDescriptors(Event::LIST_KEY);

        /** @var DoctrineListBuilder $listBuilder */
        $listBuilder = $this->listBuilderFactory->create(Event::class);
        $listBuilder->setIdField($fieldDescriptors['id']);

        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        return $this->handleView(
            $this->view(new ListRepresentation(
                $listBuilder->execute(),
                Event::RESOURCE_KEY,
                $request->attributes->get('_route'),
                $request->query->all(),
                $listBuilder->getCurrentPage(),
                $listBuilder->getLimit(),
                $listBuilder->count()
            ))
        );
    }

    public function getEventAction(Event $event): Response
    {
        return $this->handleView(
            $this->view($event)
        );
    }

    public function postEventAction(Request $request): Response
    {
        $event = new Event();
        $event->setTitle($request->request->get('title'))
            ->setDescription($request->request->get('description'))
            ->setDate(new \DateTime($request->request->get('date')));

        $this->entityManager->persist($event);

        $this->entityManager->flush();

        return $this->handleView(
            $this->view($event, Response::HTTP_CREATED)
        );
    }

    public function putEventAction(string $id, Request $request): Response
    {
        /** @var Event $event */
        $event = $this->entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            throw $this->createNotFoundException(
                'No event found for id ' . $id
            );
        }

        $event->setTitle($request->request->get('title'))
            ->setDescription($request->request->get('description'))
            ->setDate(new \DateTime($request->request->get('date')));

        $this->entityManager->flush();

        return $this->handleView(
            $this->view($event)
        );
    }

    public function deleteEventAction(Event $event): Response
    {
        $this->entityManager->remove($event);
        $this->entityManager->flush();

        return $this->handleView(
            $this->view(null, Response::HTTP_NO_CONTENT)
        );
    }
}
