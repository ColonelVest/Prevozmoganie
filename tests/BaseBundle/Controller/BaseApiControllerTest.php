<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 02.05.17
 * Time: 7:11
 */

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseApiControllerTest extends WebTestCase
{
    public function testGets($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $response = $client->getResponse();
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json; charset=UTF-8'
            ),
            'the "Content-Type" header is "application/json; charset=UTF-8"'
        );

        $decodedResponse = json_decode($response->getContent(), true);
        $this->assertTrue($decodedResponse['success'], 'response is success');
        $this->assertTrue(is_array($decodedResponse['data']), 'response data is array');
    }
}