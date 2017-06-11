<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 22:29
 */
class RecipeControllerTest extends BaseApiControllerTest
{
    public function testGetRecipes()
    {
        $this->gets('recipes');
    }

    protected function getEntityName()
    {
        return \FoodBundle\Entity\Recipe::class;
    }

    protected function getUrlEnd()
    {
        return 'recipes';
    }

    /**
     * keys: 'postData', 'queryCriteria', '$queryCriteria', 'putData', 'deleteCriteria'
     *
     * @return mixed
     */
    protected function getCRUDData()
    {
//        $postData =
        return [
            'postData', 'queryCriteria', '$queryCriteria', 'putData', 'deleteCriteria'
        ];
    }
}