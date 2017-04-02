<?php

namespace BaseBundle\Controller;

use ErrorsBundle\Entity\Error;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $errors = $em->getRepository('NotesBundle:Listener')->findAll();
        $user = $em->getRepository('UserBundle:User')->findOneBy(['username' => 'angry']);
        foreach ($errors as $error) {
            /** @var Error $error */
            $error->setUser($user);
        }
        $em->flush();
//        /** @var Task $task */
//        $task = $em->getRepository('TaskBundle:Task')->findOneBy(['title' => 'Прибраться в квартире', 'date' => \DateTime::createFromFormat('dmY', '09042017')]);
//        $task->setIsCompleted(false);
//        $task->setDate((clone($task->getDate())->modify('-1 day')));
//        $em->flush();

        return new Response();
    }
}
