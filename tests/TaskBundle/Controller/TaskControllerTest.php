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
    public function testPostRTasksAction()
    {
        $client = static::createClient();
        $token = $this->getUserToken();

        $data = [
            'token' => $token->getData(),
            'task' => [
                'entity' => [
                    'title' => 'test task',
                    'description' => 'test task description',
                    'beginTime' => '15:00',
                    'endTime' => '17:00',
                ],
                'condition' => [
                    'beginDate' => (new \DateTime('-5 days'))->format('dmY'),
                    'endDate' => (new \DateTime('+20 days'))->format('dmY'),
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

    /**
     * @depends testPostRTasksAction
     */
    public function testGetTasks()
    {
        $this->gets('taskentries');
        $params = [
            'date' => (new \DateTime('+5 days'))->format('dmY'),
        ];

        $this->gets('taskentries', $params);
    }

    protected function getEntityName()
    {
        return \TaskBundle\Entity\Task::class;
    }

    protected function getUrlEnd()
    {
        return 'tasks';
    }

    /**
     * keys: 'postData', 'queryCriteria', 'putData', 'deleteCriteria'
     *
     * @return mixed
     */
    protected function getCRUDData()
    {
        $postData = [
            'task' => [
                'entity' => [
                    'title' => 'test single task',
                    'description' => 'test task description',
                    'beginTime' => '15:00',
                    'endTime' => '17:00',
                ],
                'condition' => [
                    'dates' => [(new \DateTime())->format('dmY')],
                    'daysBeforeDeadline' => 4,
                ],
            ],
        ];

        $queryCriteria = ['title' => 'test single task'];

        $putData =  [
            'task' => [
                'title' => 'updated single test task',
                'description' => 'updated test task description',
                'beginTime' => '14:00',
                'endTime' => '17:00',
            ],
        ];

        $deleteCriteria = ['title' => 'updated single test task'];

        return [
            'postData' => $postData,
            'queryCriteria' => $queryCriteria,
            'putData' => $putData,
            'deleteCriteria' => $deleteCriteria
        ];
    }
}
