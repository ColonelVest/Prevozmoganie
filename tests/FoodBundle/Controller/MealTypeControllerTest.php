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
        $this->clearDB();
        $this->initDB();
        $token = $this->getUserToken();
        $this->gets('/api/v1/mealtypes?token=' . $token->getData());
    }
}