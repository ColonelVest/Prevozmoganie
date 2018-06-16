<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 21:52
 */
class NotesControllerTest extends BaseApiControllerTest
{
    /**
     * @throws Exception
     */
    public function testGetNotes()
    {
        $this->gets('notes');
    }

    protected function getEntityName()
    {
        return \NotesBundle\Entity\Note::class;
    }

    protected function getUrlEnd()
    {
        return 'notes';
    }

    /**
     * keys: 'postData', 'queryCriteria', 'putData', 'deleteCriteria'
     *
     * @return mixed
     */
    protected function getCRUDData()
    {
        $postData = [
            'note' => [
                'title' => 'test note',
                'body' => 'test note body',
            ]
        ];

        $queryCriteria = ['title' => 'test note'];

        $putData =  [
            'note' => [
                'body' => 'updated test note body',
            ]
        ];

        $deleteCriteria = ['title' => 'test note'];

        return [
            'postData' => $postData,
            'queryCriteria' => $queryCriteria,
            'putData' => $putData,
            'deleteCriteria' => $deleteCriteria
        ];
    }
}