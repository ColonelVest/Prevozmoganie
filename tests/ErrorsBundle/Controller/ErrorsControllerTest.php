<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 21:54
 */
class ErrorsControllerTest extends BaseApiControllerTest
{
    public function testGetErrors()
    {
        $this->gets('errors');
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