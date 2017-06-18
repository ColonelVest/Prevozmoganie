<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 18/06/2017
 * Time: 16:10
 */
class ChallengeControllerTest extends \BaseBundle\Lib\Tests\BaseApiControllerTest
{
    /**
     * @return string
     */
    protected function getEntityName()
    {
        return \TaskBundle\Entity\Challenge::class;
    }

    protected function getUrlEnd()
    {
        return 'challenges';
    }

    /**
     * keys: 'postData', 'queryCriteria', 'putData', 'deleteCriteria'
     *
     * @return mixed
     */
    protected function getCRUDData()
    {
        $shortName = \TaskBundle\Entity\Challenge::getShortName();
        $task = $this->getEntityManager()->getRepository('TaskBundle:Task')->findOneBy(['title' => 'Убрать мусор']);
        $postData = [
            $shortName => [
                'begin' => '18062017',
                'end' => '28062017',
                'tasks' => [
                    $task->getId(),
                ],
                'award' => 'Куплю большую пиццу с пивасом!',
            ],
        ];

        $queryCriteria = [
            'award' => 'Куплю большую пиццу с пивасом!',
        ];

        $putData = [
            $shortName => [
                'begin' => '19062017',
            ],
        ];

        $deleteCriteria = [
            'begin' => \DateTime::createFromFormat('dmY', '19062017'),
            'award' => 'Куплю большую пиццу с пивасом!',
        ];

        return [
            'postData' => $postData,
            'queryCriteria' => $queryCriteria,
            'putData' => $putData,
            'deleteCriteria' => $deleteCriteria,
        ];
    }
}