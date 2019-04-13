<?php

declare(strict_types=1);

namespace App\Common\Handler;

use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilder;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\RestHelperInterface;

class ListQueryHandler
{
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
        DoctrineListBuilderFactoryInterface $listBuilderFactory,
        RestHelperInterface $restHelper,
        ?FieldDescriptorFactoryInterface $fieldDescriptorsFactory
    ) {
        $this->listBuilderFactory = $listBuilderFactory;
        $this->restHelper = $restHelper;

        if (!$fieldDescriptorsFactory) {
            throw new \RuntimeException(
                'FieldDescriptorFactory cannot be null - possible call within the website context.'
            );
        }

        $this->fieldDescriptorsFactory = $fieldDescriptorsFactory;
    }

    protected function createListRepresentation(
        string $entityName,
        string $listKey,
        string $resourceKey,
        array $query,
        string $route
    ): ListRepresentation {
        $fieldDescriptors = $this->fieldDescriptorsFactory->getFieldDescriptors($listKey);

        /** @var DoctrineListBuilder $listBuilder */
        $listBuilder = $this->listBuilderFactory->create($entityName);
        $listBuilder->setIdField($fieldDescriptors['id']);

        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        return new ListRepresentation(
            $listBuilder->execute(),
            $resourceKey,
            $route,
            $query,
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit(),
            $listBuilder->count()
        );
    }
}
