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
        $data = [
            'title' => 'test task',
            'description' => 'test task description',
            'taskEntries' => [
                [
                    'isCompleted' => true,
                ]
            ],
//            'date' => (new \DateTime())->format('dmY'),
//            'beginTime' => new \DateTime(),
            'endTime' => '17:00',
//            'deadline' => (new \DateTime('+4 days'))->format('dmY')
        ];
        $normalizer = $this->get('pv_normalizer');
        $task = $this->get('pv_normalizer')->denormalize($data, Task::class);
//        $em->flush();

        return [];
    }
}
