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
        $em = $this->get('doctrine.orm.default_entity_manager');
        $tasks = $em->getRepository('TaskBundle:Task')->findBy(['title' => 'Постирать постельное белье']);
        foreach ($tasks as $task) {
            $em->remove($task);
        }
        $em->flush();
        return new Response();
    }
}
