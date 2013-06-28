devilciusAdminMenuBundle
=================

This is based on [**AdminBundle**][1] and extends the [**SonataAdminBundle**][2]. It offers the possibility to manage the menu from other bundle.

See [**how to install and configure**][3]


Manage menu
-----------

The SonataAdminBundle main menu (on top of all Admin pages) is generated with a list of Admin objects.

This bundle extends the menu and allows everyone to modify this menu.

The admin menu is generated with [**KnpMenu**][4] library. By default it retrieves all admin groups and labels Admin (like default menu renderer).

To modify the admin menu just register a listener :
```php

namespace devilcius\TestBundle\EventListener;


class MenuListener
{
    public function createMenu($event)
    {
        $menu = $event->getMenu();

        // create a new group
        $menu->addChild('Audit', array('translationDomain'=>'MyDomain'));

        // add a divider to System group
        $menu['Audit']->addDivider();
        // ad a nav header
        $menu['Audit']->addNavHeader('SubMenu');

        // add list child
        $menu['Audit']->addChild('List', array('uri'=>'admin/audit/list'));

    }
}
```

And just declare the listener in your services.yml file.

```yml
services:
    kernel.listener.admin_menu_listener:
        class: devilcius\TestBundle\EventListener\MenuListener
        tags:
            - { name: kernel.event_listener, event: admin.menu.create, method: createMenu }
```

This bundle use a custom MenuItem class `devilcius\AdminMenuBundle\Menu\MenuItem` that extends the `Knp\Menu\MenuItem`. It add new functions (to add dividers, nav headers, ...)


Controllers used in the the admin menu must extend the AdminMenuController

```
use devilcius\AdminMenuBundle\Controller\AdminMenuController as Controller;
class AuditController extends Controller
{
[...]
```

[1]: https://github.com/devilcius/AdminMenuBundle
[2]: http://sonata-project.org/bundles/admin/master/doc/index.html
[3]: https://github.com/devilcius/AdminMenuBundle/blob/master/Resources/doc/installation.md
[4]: https://github.com/KnpLabs/KnpMenu