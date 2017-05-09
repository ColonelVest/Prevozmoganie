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
        $this->gets('tasks');
        $params = [
            'date' => '06052017'
        ];

        $this->gets('tasks', $params);
    }
}
