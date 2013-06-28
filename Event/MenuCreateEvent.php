<?php

namespace devilcius\AdminMenuBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use devilcius\AdminMenuBundle\Menu\MenuItem;


class MenuCreateEvent extends Event
{
    protected $menu;

    /**
     * __construct
     *
     * @param MenuItem $menu [description]
     */
    public function __construct(MenuItem $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Gets the menu
     *
     * @return \devilcius\AdminMenuBundle\Menu\MenuItem
     */
    public function getMenu()
    {
        return $this->menu;
    }
}