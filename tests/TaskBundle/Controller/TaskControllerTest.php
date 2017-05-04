<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 01.05.17
 * Time: 22:10
 */

use BaseBundle\Lib\Tests\BaseApiControllerTest;

class TaskControllerTest extends BaseApiControllerTest
{
    public function testGetTasks()
    {
        $this->clearDB();
        $this->initDB();
        $token = $this->getUserToken();
        $this->gets('/api/v1/tasks?token=' . $token->getData());
    }
}
