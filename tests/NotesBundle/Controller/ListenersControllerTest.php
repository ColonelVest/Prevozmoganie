<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 22:01
 */
class ListenersControllerTest extends \BaseBundle\Lib\Tests\BaseApiControllerTest
{
    public function testGetListeners()
    {
        $this->gets('listeners');
    }
}