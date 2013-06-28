<?php

namespace devilcius\AdminMenuBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcher;
use devilcius\AdminMenuBundle\Event\MenuCreateEvent;
use devilcius\AdminMenuBundle\Event\MenuEvents;

class MenuBuilder
{
    protected $container = null;
    protected $factory;

    /**
     *__constructor
     * 
     * @param FactoryInterface   $factory   Menu Factory
     * @param ContainerInterface $container Container
     */
    public function __construct(FactoryInterface $factory, ContainerInterface $container)
    {
        $this->factory = $factory;
        $this->setContainer($container);
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     *
     * @return null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Create the main menu
     *
     * @param Request $request [description]
     *
     * @return [type]
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->setCurrentUri($request->getBaseUrl().$request->getPathInfo());

        // create menu from admin pool
        $admin_pool = $this->container->get('sonata.admin.pool');
        foreach ($admin_pool->getDashboardGroups() as $group) {
            $menu->addChild($group['label'], array('translationDomain'=>$group['label_catalogue']));
            foreach ($group['items'] as $admin) {
                if ( $admin->hasRoute('list') && $admin->isGranted('LIST') ) {
                    $menu[$group['label']]->addChild($admin->getLabel(), array('admin'=>$admin));
                }
            }
        }

        $dispatcher = $this->container->get('event_dispatcher');

        $event = new MenuCreateEvent($menu);
        $dispatcher->dispatch(MenuEvents::ADMIN_MENU_CREATE, $event);

        return $menu;
    }

}