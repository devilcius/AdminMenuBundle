<?php

namespace devilcius\AdminMenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('devilciusAdminMenuBundle:Default:index.html.twig', array('name' => $name));
    }
}
