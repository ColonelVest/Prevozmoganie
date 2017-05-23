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
//    public function testGetTasks()
//    {
//        $this->gets('tasks');
//        $params = [
//            'date' => '06052017',
//        ];
//
//        $this->gets('tasks', $params);
//    }

    public function testPostRTasksAction()
    {
        $client = static::createClient();
        $token = $this->getUserToken();

        $data = [
            'token' => $token->getData(),
            'tasks' => [
                'task' => [
                    'title' => 'test task',
                    'description' => 'test task description',
                    'beginTime' => '15:00',
                    'endTime' => '17:00',
                ],
                'condition' => [
                    'beginDate' => '20052017',
                    'endDate' => '20062017',
                    'weekFrequency' => 1,
                    'daysBeforeDeadline' => 4,
                ],
            ],
        ];

        $url = '/api/v1/rtasks';
        $client->request('POST', $url, $data);
        $response = $client->getResponse();
        $this->assertApiResponse($response);
    }
//
//    public function testPostAction()
//    {
//        $client = static::createClient();
//        $token = $this->getUserToken();
//
//        $data = [
//            'token' => $token->getData(),
//            'task' => [
//                'title' => 'test task',
//                'description' => 'test task description',
//                'date' => (new \DateTime())->format('dmY'),
//                'beginTime' => '15:00',
//                'endTime' => '17:00',
//                'deadline' => (new \DateTime('+4 days'))->format('dmY')
//            ],
//        ];
//
//        $url = '/api/v1/tasks';
//        $client->request('POST', $url, $data);
//        $response = $client->getResponse();
//        $this->assertApiResponse($response);
//        $this->assertPostSingleObjectResponse($response, \TaskBundle\Entity\Task::class);
//    }

    /**
     * @depends testGetAction
     */
//    public function testPutAction()
//    {
//        $client = static::createClient();
//        $token = $this->getUserToken();
//
//        $data = [
//            'token' => $token->getData(),
//            'task' => [
//                'title' => 'updated test task',
//                'description' => 'updated test task description',
//                'date' => (new \DateTime())->format('dmY'),
//                'beginTime' => '14:00',
//                'endTime' => '17:00',
//                'deadline' => (new \DateTime('+4 days'))->format('dmY'),
//            ],
//        ];
//        $testEntity = $this->getEntityManager()->getRepository('TaskBundle:Task')->findOneBy(['title' => 'test task']);
//        $url = '/api/v1/tasks/'.$testEntity->getId();
//        $client->request('PUT', $url, $data);
//        $response = $client->getResponse();
//        $this->assertApiResponse($response);
//        $this->assertPostSingleObjectResponse($response, \TaskBundle\Entity\Task::class);
//    }

//    /**
//     * @depends testPostAction
//     */
//    public function testGetAction()
//    {
//        $client = static::createClient();
//        $token = $this->getUserToken();
//
//        $testEntity = $this->getEntityManager()
//            ->getRepository('TaskBundle:Task')
//            ->findOneBy(['title' => 'test task']);
//        $this->assertNotNull($testEntity, 'searched task not found');
//        $url = '/api/v1/tasks/'.$testEntity->getId().'?token='.$token->getData();
//        $client->request('GET', $url);
//        $response = $client->getResponse();
//        $this->assertApiResponse($response);
//        //TODO: Добавить возврат нужного объекта, когда будет очередность вызова методов
//    }
//
//    /**
//     * @depends testPutAction
//     */
//    public function testDeleteAction()
//    {
//        $client = static::createClient();
//        $token = $this->getUserToken();
//
//        $testEntity = $this->getEntityManager()
//            ->getRepository('TaskBundle:Task')
//            ->findOneBy(['title' => 'updated test task']);
//        $this->assertNotNull($testEntity, 'searched task not found');
//
//        $url = '/api/v1/tasks/'.$testEntity->getId().'?token='.$token->getData();
//        $client->request('DELETE', $url);
//
//        $response = $client->getResponse();
//        $this->assertApiResponse($response);
//        $decodedResponse = json_decode($response->getContent(), true);
//        $this->assertEquals($testEntity->getId(), $decodedResponse['data']);
//    }
}
