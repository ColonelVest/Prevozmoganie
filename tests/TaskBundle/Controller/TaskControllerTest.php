<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 01.05.17
 * Time: 22:10
 */

class TaskControllerTest extends BaseApiControllerTest
{
    public function testGetTasks()
    {
        $this->testGets('/api/v1/tasks?token=angry|$2y$13$g2PWcpGXezW5JktcoDWOBeQVDA4VtlYOgY9Oy3QrUbH8HphXUhV9y');
    }
}
