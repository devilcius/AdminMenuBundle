<?php

namespace devilcius\AdminMenuBundle\Menu;

use Knp\Menu\Silex\RouterAwareFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class MenuFactory extends RouterAwareFactory implements ContainerAwareInterface
{
    protected $container = null;

    /**
     * [__construct description]
     *
     * @param ContainerInterface $container [description]
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        parent::__construct($this->container->get('router'));
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
     * Create an item
     *
     * @param string $name    Name of the item
     * @param array  $options Options
     *
     * @return devilcius\AdminMenuBundle\Menu\MenuItem
     */
    public function createItem($name, array $options = array())
    {
        if (!empty($options['admin'])) {
            $admin = $options['admin'];
            if ( !$options['admin'] instanceof AdminInterface ) {
                $admin = $this->container->get('sonata.admin.pool')->getAdminByAdminCode($admin);
            }
            $action = isset($options['admin_action']) ? $options['admin_action'] : 'list';
            $options['uri'] = $admin->generateUrl($action);
            $options['translationDomain'] = $admin->getTranslationDomain();
        }
        /**
         * Knp\Menu\Silex\RouterAwareFactory
         */
        if (!empty($options['route'])) {
            $params = isset($options['routeParameters']) ? $options['routeParameters'] : array();
            $absolute = isset($options['routeAbsolute']) ? $options['routeAbsolute'] : false;
            $options['uri'] = $this->generator->generate($options['route'], $params, $absolute);
        }
        
        // use devilcius\AdminMenuBundle\Menu\MenuItem
        $item = new MenuItem($name, $this);

        $options = array_merge(
            array(
                'uri' => null,
                'label' => null,
                'attributes' => array(),
                'linkAttributes' => array(),
                'childrenAttributes' => array(),
                'labelAttributes' => array(),
                'extras' => array(),
                'display' => true,
                'displayChildren' => true,
                'translationDomain' => 'messages',
                'roles' => null,
                'displayLink' => true,
                'displayLabel' => true,
            ),
            $options
        );

        $item
            ->setUri($options['uri'])
            ->setLabel($options['label'])
            ->setAttributes($options['attributes'])
            ->setLinkAttributes($options['linkAttributes'])
            ->setChildrenAttributes($options['childrenAttributes'])
            ->setLabelAttributes($options['labelAttributes'])
            ->setExtras($options['extras'])
            ->setDisplay($options['display'])
            ->setDisplayChildren($options['displayChildren'])
            ->setTranslationDomain($options['translationDomain'])
            ->setRoles($options['roles'])
            ->setDisplayLink($options['displayLink'])
            ->setDisplayLabel($options['displayLabel']);
        
        return $item;

        return parent::createItem($name, $options);
    }
}
