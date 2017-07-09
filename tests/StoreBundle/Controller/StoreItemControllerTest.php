<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

class StoreItemControllerTest extends BaseApiControllerTest
{
    public function testGetItemEntries()
    {
        $this->gets('storeitems');
    }

    protected function getEntityName()
    {
        return \StoreBundle\Entity\StoreItem::class;
    }

    protected function getUrlEnd()
    {
        return 'storeitems';
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
            'storeitem' => [
            ]
        ];
        $queryCriteria = [];
        $putData = [
            'storeitem' => []
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