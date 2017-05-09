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
        $this->gets('meals');
    }
}