<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

class ItemControllerTest extends BaseApiControllerTest
{
    public function testGetItems()
    {
        $this->gets('items');
    }

    protected function getEntityName()
    {
        return \StoreBundle\Entity\Item::class;
    }

    protected function getUrlEnd()
    {
        return 'items';
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
            'Item' => [
            ]
        ];
        $queryCriteria = [];
        $putData = [
            'Item' => []
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