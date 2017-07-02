<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

class ItemEntryControllerTest extends BaseApiControllerTest
{
    public function testGetItemEntries()
    {
        $this->gets('itementries');
    }

    protected function getEntityName()
    {
        return \StoreBundle\Entity\ItemEntry::class;
    }

    protected function getUrlEnd()
    {
        return 'itementries';
    }

    /**
    * keys: 'postData', 'queryCriteria', 'putData', 'deleteCriteria'
    *
    * @return mixed
    */
    protected function getCRUDData()
    {
        //TODO: Заполнить данными
        $postData = [
            'itementry' => [
            ]
        ];
        $queryCriteria = [];
        $putData = [
            'itementry' => []
        ];
        $deleteCriteria = [];

        return [
            'postData' => $postData,
            'queryCriteria' => $queryCriteria,
            'putData' => $putData,
            'deleteCriteria' => $deleteCriteria
        ];
    }
}