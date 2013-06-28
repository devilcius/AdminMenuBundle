<?php

namespace devilcius\AdminMenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


abstract class AdminMenuController extends Controller
{
    /**
     * Render a view
     * 
     * @param string   $view       Twig view
     * @param array    $parameters View parameters
     * @param Response $response   Response
     *
     * @return Response
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['base_template'] = isset($parameters['base_template']) ? $parameters['base_template'] : $this->getBaseTemplate();
        $parameters['admin_pool']    = $this->get('sonata.admin.pool');

        return parent::render($view, $parameters);
    }

    /**
     * return the base template name
     *
     * @return string the template name
     */
    public function getBaseTemplate()
    {
        if ($this->get('request')->isXmlHttpRequest()) {
            return 'SonataAdminBundle::ajax_layout.html.twig';
        }

        return 'SonataAdminBundle::standard_layout.html.twig';
    }
}
