<?php

use BaseBundle\Lib\Tests\BaseApiControllerTest;

/**
 * Created by PhpStorm.
 * User: danya
 * Date: 11/06/2017
 * Time: 21:32
 */
class TaskEntryControllerTest extends BaseApiControllerTest
{

    protected function getEntityName()
    {
        return \TaskBundle\Entity\TaskEntry::class;
    }

    protected function getUrlEnd()
    {
        return 'taskentries';
    }

    /**
     * keys: 'postData', 'queryCriteria', 'putData', 'deleteCriteria'
     *
     * @return mixed
     */
    protected function getCRUDData()
    {
        // TODO: Implement getCRUDData() method.
    }
}