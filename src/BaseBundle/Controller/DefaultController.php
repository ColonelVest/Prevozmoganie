<?php

namespace BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $data = $this->get('doctrine.orm.default_entity_manager')->getRepository('TaskBundle:Task')->findAll();
        return new Response();
    }
}
