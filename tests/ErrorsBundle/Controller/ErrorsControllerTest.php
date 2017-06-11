<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 21:54
 */
class ErrorsControllerTest extends BaseApiControllerTest
{
    public function testGetErrors()
    {
        $this->gets('errors');
    }

    protected function getEntityName()
    {
        return \ErrorsBundle\Entity\Error::class;
    }

    protected function getUrlEnd()
    {
        return 'errors';
    }

    /**
     * keys: 'postData', 'queryCriteria', 'putData', 'deleteCriteria'
     *
     * @return mixed
     */
    protected function getCRUDData()
    {
        $postData = [
            'error' => [
                'title' => 'test title',
                'body' => 'test body',
                'reason' => 'test reason',
                'solution' => 'test solution',
                'type' => 'typo',
                'prevention' => 'test prevention'
            ]
        ];
        $queryCriteria = ['title' => 'test title'];
        $putData = [
            'error' => [
                'title' => 'updated test title'
            ]
        ];
        $deleteCriteria = ['title' => 'updated test title'];

        return [
            'postData' => $postData,
            'queryCriteria' => $queryCriteria,
            'putData' => $putData,
            'deleteCriteria' => $deleteCriteria
        ];
    }
}