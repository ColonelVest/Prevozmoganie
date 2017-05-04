<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 22:32
 */
class MealControllerTest extends \BaseBundle\Lib\Tests\BaseApiControllerTest
{
    public function testGetMeals()
    {
        $this->clearDB();
        $this->initDB();
        $token = $this->getUserToken();
        $this->gets('/api/v1/meals?token=' . $token->getData());
    }
}