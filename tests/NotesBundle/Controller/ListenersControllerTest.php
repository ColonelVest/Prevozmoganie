<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 22:01
 */
class ListenersControllerTest extends BaseApiControllerTest
{
    public function testGetListeners()
    {
        $this->gets('listeners');
    }

    protected function getEntityName()
    {
        return \NotesBundle\Entity\Listener::class;
    }

    protected function getUrlEnd()
    {
        return 'listeners';
    }

    /**
     * keys: 'postData', 'queryCriteria', 'putData', 'deleteCriteria'
     *
     * @return mixed
     */
    protected function getCRUDData()
    {
        $postData = [
            'listener' => [
                'actions' => ['test action'],
                'event' => 'test event'
            ]
        ];

        $queryCriteria = ['event' => 'test event'];

        $putData = [
            'listener' => [
                'actions' => ['test action'],
                'event' => 'updated test event'
            ]
        ];

        $deleteCriteria = ['event' => 'updated test event'];

        return [
            'postData' => $postData,
            'queryCriteria' => $queryCriteria,
            'putData' => $putData,
            'deleteCriteria' => $deleteCriteria
        ];
    }
}