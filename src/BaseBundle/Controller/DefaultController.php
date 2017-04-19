<?php

namespace BaseBundle\Controller;

use FoodBundle\Entity\IngredientData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TaskBundle\Entity\Task;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $recipe = $em->getRepository('FoodBundle:Recipe')->findOneBy(['title' => 'Сидим дома']);
        $em->remove($recipe);
        $em->flush();
//        $user = $em->find('UserBundle:User', 1)->getAchievements()->toArray();
//        $result = $this->get('base_helper')->getArrayWithKeysByMethodName($entities);
//        $this->get('achievement_manager')->generate();
//        /** @var Task $task */
//        $task = $em->getRepository('TaskBundle:Task')->findOneBy(['title' => 'Прибраться в квартире', 'date' => \DateTime::createFromFormat('dmY', '09042017')]);
//        $task->setIsCompleted(false);
//        $task->setDate((clone($task->getDate())->modify('-1 day')));
//        $em->flush();

        return new Response();
    }
}
