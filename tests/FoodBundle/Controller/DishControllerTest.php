<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 22:28
 */
class DishControllerTest extends \BaseBundle\Lib\Tests\BaseApiControllerTest
{
    public function testGetDishes()
    {
        $this->gets('dishes');
    }
}