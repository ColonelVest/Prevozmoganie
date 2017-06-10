<?php

namespace BaseBundle\Controller;

use FoodBundle\Entity\IngredientData;
use FoodBundle\Entity\MealEntry;
use FoodBundle\Entity\MealEntryRepository;
use FoodBundle\Entity\MealType;
use FoodBundle\Model\RepetitiveMeal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TaskBundle\Entity\Task;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET"})
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $sdfsdf = 123;
//        $data = [
//            'title' => 'test task',
//            'description' => 'test task description',
//            'taskEntries' => [12],
//            'date' => (new \DateTime())->format('dmY'),
//            'beginTime' => '15:00',
//            'endTime' => '17:00',
//        ];
//        $em->persist(new Task());
//        $normalizer = $this->get('pv_normalizer');
//        $task = $this->get('pv_normalizer')->fillEntity(new Task(), $data, false);

//        $em->flush();

        return [];
    }
}
