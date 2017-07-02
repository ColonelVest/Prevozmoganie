<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

class BuyItemControllerTest extends BaseApiControllerTest
{
    public function testGetBuyItems()
    {
        $this->gets('buyitems');
    }

    protected function getEntityName()
    {
        return \StoreBundle\Entity\BuyItem::class;
    }

    protected function getUrlEnd()
    {
        return 'buyitems';
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
            'buyitem' => [
            ]
        ];
        $queryCriteria = [];
        $putData = [
            'buyitem' => []
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