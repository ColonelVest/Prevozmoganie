<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 13.05.17
 * Time: 21:28
 */

namespace TaskBundle\Services;

use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use BaseBundle\Services\BaseHelper;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use UserBundle\Entity\User;

class TaskEntryHandler extends EntityHandler
{
    private $helper;

    public function __construct(
        EntityManager $em,
        ApiResponseFormatter $responseFormatter,
        RecursiveValidator $validator,
        BaseHelper $helper
    ) {
        parent::__construct($em, $responseFormatter, $validator);
        $this->helper = $helper;
    }

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:TaskEntry');
    }

    public function getLengthOfCompletedTasksInDays(\DateTime $date, User $user)
    {
        $uncompletedDayStr = $this->em
            ->getRepository('TaskBundle:TaskEntry')
            ->getLastDayWithUncompletedTask($date, $user);

        $uncompletedDay = $this->helper->createDateFromString($uncompletedDayStr, 'Y-m-d');
        if ($uncompletedDay === false) {
            return Result::createSuccessResult(0);
        }

        return Result::createSuccessResult($date->diff($uncompletedDay)->d - 1);
    }
}