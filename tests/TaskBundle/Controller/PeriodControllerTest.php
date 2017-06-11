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
    public function testPostPeriodAction()
    {
        $data = [
            'period' => [
                'description' => 'test period',
                'begin' => '10:00',
                'end' => '11:00',
                'date' => (new \DateTime('midnight'))->format('dmY')
            ]
        ];

        $this->postRequest($data);
    }

    /**
     * @depends testPostPeriodAction
     */
    public function testGetPeriodAction()
    {
        $this->getRequest(['description' => 'test period']);
    }

    /**
     * @depends testPostPeriodAction
     */
    public function testPutPeriodAction()
    {
        $data = [
            'period' => [
                'description' => 'updated test period',
            ]
        ];

        $this->putRequest(['description' => 'test period'], $data);
    }

    public function testDeleteAction()
    {
        $this->deleteRequest(['description' => 'updated test period']);
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