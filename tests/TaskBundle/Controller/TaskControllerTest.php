<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 01.05.17
 * Time: 22:10
 */

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testGetTasks()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/tasks?token=angry|$2y$13$g2PWcpGXezW5JktcoDWOBeQVDA4VtlYOgY9Oy3QrUbH8HphXUhV9y');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
