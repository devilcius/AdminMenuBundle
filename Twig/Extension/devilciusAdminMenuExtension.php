<?php

namespace devilcius\AdminMenuBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class devilciusAdminMenuExtension extends \Twig_Extension implements ContainerAwareInterface
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
     * Gets filters
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            'render_attributes' => new \Twig_Filter_Method($this, 'renderAttributes', array('is_safe' => array('html'))),
        );
    }

    /**
     * renderAttributes
     *
     * @param array $attributes attributes to render
     * @param array $defaults   defaults value
     *
     * @return [type]
     */
    public function renderAttributes(array $attributes, array $defaults = array())
    {
        $s = '';
        foreach ($attributes as $name => $value) {
            if ( array_key_exists($name, $defaults) ) {
                $value = $value.' '.$defaults[$name];
            }
            $s .= sprintf(' %s="%s"', $name, $value);
        }
        foreach ($defaults as $name => $value) {
            if ( !array_key_exists($name, $attributes) ) {
                $s .= sprintf(' %s="%s"', $name, $value);
            }
        }
        return $s;
    }

    
    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'devilcius_admin_menu';
    }

}
