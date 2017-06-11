<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 22:31
 */
class IngredientControllerTest extends \BaseBundle\Lib\Tests\BaseApiControllerTest
{
    public function testGetIngredients()
    {
        $this->gets('ingredients');
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