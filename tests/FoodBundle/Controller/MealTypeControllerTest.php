<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 22:30
 */
class MealTypeControllerTest extends \BaseBundle\Lib\Tests\BaseApiControllerTest
{
    public function testGetMealTypes()
    {
        $this->gets('mealtypes');
    }

    protected function getEntityName()
    {
        // TODO: Implement getEntityName() method.
    }

    protected function getUrlEnd()
    {
        // TODO: Implement getUrlEnd() method.
    }
}