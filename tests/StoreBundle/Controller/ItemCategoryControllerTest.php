<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

class ItemCategoryControllerTest extends BaseApiControllerTest
{
    public function testGetItemCategories()
    {
        $this->gets('itemcategories');
    }

    protected function getEntityName()
    {
        return \StoreBundle\Entity\ItemCategory::class;
    }

    protected function getUrlEnd()
    {
        return 'itemcategories';
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
            'itemcategory' => [
            ]
        ];
        $queryCriteria = [];
        $putData = [
            'itemcategory' => []
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