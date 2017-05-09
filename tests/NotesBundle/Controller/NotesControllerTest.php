<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 04.05.17
 * Time: 21:52
 */
class NotesControllerTest extends BaseApiControllerTest
{
    public function testGetNotes()
    {
        $this->gets('notes');
    }
}