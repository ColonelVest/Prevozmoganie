<?php

namespace TaskBundle\Tests\Service;

use TaskBundle\Service\DateTimeHandler;


class DatetimeHandlerTest extends \PHPUnit_Framework_TestCase
{
    //Дерьмотесты((((9999
    public function testGetDateFromString()
    {
        $dateTimeHandler = new DateTimeHandler();
        $date = \DateTime::createFromFormat('d-m-Y', '22-02-1991');
        $testingDate = $dateTimeHandler->getDateFromString('22-02-1991');
        $this->assertEquals($date, $testingDate);

        $this->assertEquals(new \DateTime(), $dateTimeHandler->getDateFromString(null));
    }
}