<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Event;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Routing\RouteBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Navigation\Navigation;
use Sulu\Bundle\AdminBundle\Navigation\NavigationItem;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;

class EventAdmin extends Admin
{
    const SECURITY_CONTEXT = 'app.events';
    const LIST_ROUTE = 'app_events.list';
    const ADD_FORM_ROUTE = 'app_events.add_form';
    const EDIT_FORM_ROUTE = 'app_events.edit_form';

    /**
     * @var RouteBuilderFactoryInterface
     */
    private $routeBuilderFactory;

    /**
     * @var SecurityCheckerInterface
     */
    private $securityChecker;

    public function __construct(
        RouteBuilderFactoryInterface $routeBuilderFactory,
        SecurityCheckerInterface $securityChecker
    ) {
        $this->routeBuilderFactory = $routeBuilderFactory;
        $this->securityChecker = $securityChecker;
    }

    public function getNavigationItemEvent(): NavigationItem
    {
        $module = new NavigationItem('app.main_navigation_events');
        $module->setPosition(40);
        $module->setIcon('su-calendar');

        return $module;
    }

    public function getNavigation(): Navigation
    {
        $rootNavigationItem = $this->getNavigationItemRoot();

        $module = $this->getNavigationItemEvent();

        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $events = new NavigationItem('app.events');
            $events->setPosition(10);
            $events->setMainRoute(static::LIST_ROUTE);
            $module->addChild($events);
        }

        if ($module->hasChildren()) {
            $rootNavigationItem->addChild($module);
        }

        return new Navigation($rootNavigationItem);
    }

    public function getRoutes(): array
    {

        $formToolbarActions = [
            'sulu_admin.save',
            'sulu_admin.delete',
        ];

        $listToolbarActions = [
            'sulu_admin.add',
            'sulu_admin.delete',
            'sulu_admin.export',
        ];

        return [
            $this->routeBuilderFactory->createListRouteBuilder(static::LIST_ROUTE, '/events')
                ->setResourceKey(Event::RESOURCE_KEY)
                ->setListKey(Event::LIST_KEY)
                ->setTitle('app.events')
                ->addListAdapters(['table'])
                ->setAddRoute(static::ADD_FORM_ROUTE)
                ->setEditRoute(static::EDIT_FORM_ROUTE)
                ->addToolbarActions($listToolbarActions)
                ->getRoute(),
            $this->routeBuilderFactory->createResourceTabRouteBuilder(static::ADD_FORM_ROUTE, '/events/add')
                ->setResourceKey(Event::RESOURCE_KEY)
                ->setBackRoute(static::LIST_ROUTE)
                ->getRoute(),
            $this->routeBuilderFactory->createFormRouteBuilder(static::ADD_FORM_ROUTE . '.details', '/details')
                ->setResourceKey(Event::RESOURCE_KEY)
                ->setFormKey(Event::FORM_KEY)
                ->setTabTitle('app.details')
                ->setEditRoute(static::EDIT_FORM_ROUTE)
                ->addToolbarActions($formToolbarActions)
                ->setParent(static::ADD_FORM_ROUTE)
                ->getRoute(),
            $this->routeBuilderFactory->createResourceTabRouteBuilder(static::EDIT_FORM_ROUTE, '/events/:id')
                ->setResourceKey(Event::RESOURCE_KEY)
                ->setBackRoute(static::LIST_ROUTE)
                ->setTitleProperty('title')
                ->getRoute(),
            $this->routeBuilderFactory->createFormRouteBuilder(static::EDIT_FORM_ROUTE . '.details', '/details')
                ->setResourceKey(Event::RESOURCE_KEY)
                ->setFormKey(Event::FORM_KEY)
                ->setTabTitle('app.details')
                ->addToolbarActions($formToolbarActions)
                ->setParent(static::EDIT_FORM_ROUTE)
                ->getRoute(),
        ];
    }

    public function getSecurityContexts()
    {
        return [
            'Sulu' => [
                'Event' => [
                    static::SECURITY_CONTEXT => [
                        PermissionTypes::VIEW,
                        PermissionTypes::ADD,
                        PermissionTypes::EDIT,
                        PermissionTypes::DELETE,
                    ],
                ],
            ],
        ];
    }

    protected function getBundleName()
    {
        return 'app';
    }
}
