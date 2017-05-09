<?php

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 02.05.17
 * Time: 7:11
 */

namespace BaseBundle\Lib\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\NullOutput;

abstract class BaseApiControllerTest extends WebTestCase
{
    abstract protected function tPostAction();
    abstract protected function tPutAction();
    abstract protected function tGetAction();
    abstract protected function tDeleteAction();

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

    protected function getContainer()
    {
        return static::$kernel->getContainer();
    }

    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.default_entity_manager');
    }

    protected function gets($entitiesName, $params = [])
    {
        self::clearDB();
        $this->initDB();
        $client = static::createClient();
        $token = $this->getUserToken();
        $url = '/api/v1/'. $entitiesName .'?token=' . $token->getData();
        foreach ($params as $paramName => $value) {
            $url .= '&' . $paramName . '=' . $value;
        }

        $client->request('GET', $url);

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful(), 'response status is not 2xx');
        $this->assertTrue(
            $response->headers->contains(
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
        $container = $this->getContainer();

        if (is_null($user)) {
            $user = $container->get('doctrine.orm.default_entity_manager')
                ->getRepository('UserBundle:User')
                ->findOneBy(['username' => 'angry']);
        }

        return $container->get('token_handler')->encode($user->getUsername(), $user->getPassword());
    }

    protected function assertApiResponse(Response $response)
    {
        $this->assertTrue($response->isSuccessful(), 'response status is not 2xx');
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json; charset=UTF-8'
            ),
            'the "Content-Type" header is "application/json; charset=UTF-8"'
        );

        $decodedResponse = json_decode($response->getContent(), true);
        $errors = '';
        if (isset($decodedResponse['errors'])) {
            $errorsList = $decodedResponse['errors'];
            $errors = 'Errors: ' . join(', ', $errorsList);
        }
        $this->assertTrue($decodedResponse['success'], $errors);
    }

    protected function assertPostSingleObjectResponse(Response $response, $entityName)
    {
        $decodedResponse = json_decode($response->getContent(), true);
        $createdObject = $this->getEntityManager()->find($entityName, $decodedResponse['data']['id']);
        $this->assertNotNull($createdObject, 'new object' . $entityName . 'not found');
    }

    public function testCRUD()
    {
        $this->tPostAction();
        $this->tGetAction();
        $this->tPutAction();
        $this->tDeleteAction();
    }
}