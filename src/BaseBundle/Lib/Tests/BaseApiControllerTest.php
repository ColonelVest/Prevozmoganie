<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 02.05.17
 * Time: 7:11
 */

namespace BaseBundle\Lib\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UserBundle\Entity\User;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\NullOutput;

abstract class BaseApiControllerTest extends WebTestCase
{
    /**
     * Run console command
     * @param string $name
     * @param array $options
     */
    public static function command(string $name, $options = [])
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $application->setAutoExit(false);
        $arrayInput = array_merge(['command' => $name], $options);

        $input = new ArrayInput($arrayInput);
        $output = new NullOutput();
        $application->run($input, $output);
    }

    public static function clearDB()
    {
        self::command('doctrine:schema:drop');
    }

    public function initDB()
    {
        self::command('doctrine:schema:update', ['--force' => true]);
        self::command('doctrine:fixtures:load');
    }

    protected function gets($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $response = $client->getResponse();
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is not 2xx');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json; charset=UTF-8'
            ),
            'the "Content-Type" header is "application/json; charset=UTF-8"'
        );

        $decodedResponse = json_decode($response->getContent(), true);
        $this->assertTrue($decodedResponse['success'], 'response is not successful');
        $this->assertTrue(is_array($decodedResponse['data']), 'response data is not array');
    }

    protected function getUserToken(User $user = null)
    {
        $client = static::createClient();
        $container = $client->getContainer();

        if (is_null($user)) {
            $user = $container->get('doctrine.orm.default_entity_manager')
                ->getRepository('UserBundle:User')
                ->findOneBy(['username' => 'angry']);
        }

        return $container->get('token_handler')->encode($user->getUsername(), $user->getPassword());
    }
}