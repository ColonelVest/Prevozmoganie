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
        $this->clearDB();
        $this->initDB();
        $token = $this->getUserToken();
        $this->gets('/api/v1/notes?token=' . $token->getData());
    }
}