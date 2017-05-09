<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 22:29
 */
class RecipeControllerTest extends \BaseBundle\Lib\Tests\BaseApiControllerTest
{
    public function testGetRecipes()
    {
        $this->gets('recipes');
    }
}