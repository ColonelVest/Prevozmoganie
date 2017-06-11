<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 11/06/2017
 * Time: 18:02
 */
class PeriodControllerTest extends BaseApiControllerTest
{
    /**
     * keys: 'postData', 'queryCriteria', 'putData', 'deleteCriteria'
     *
     * @return mixed
     */
    protected function getCRUDData()
    {
        $postData = [
            'period' => [
                'description' => 'test period',
                'begin' => '10:00',
                'end' => '11:00',
                'date' => (new \DateTime('midnight'))->format('dmY')
            ]
        ];

        $queryCriteria = ['description' => 'test period'];

        $putData =  [
            'period' => [
                'description' => 'updated test period',
            ]
        ];

        $deleteCriteria = ['description' => 'updated test period'];

        return [
            'postData' => $postData,
            'queryCriteria' => $queryCriteria,
            'putData' => $putData,
            'deleteCriteria' => $deleteCriteria
        ];
    }

    protected function getEntityName()
    {
        return \TaskBundle\Entity\Period::class;
    }

    protected function getUrlEnd()
    {
        return 'periods';
    }
}