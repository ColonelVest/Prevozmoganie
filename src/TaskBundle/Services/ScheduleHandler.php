<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\User;
use BaseBundle\Models\ErrorMessageHandler;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use TaskBundle\Entity\Schedule;

/**
 * Действия с расписанием
 * Class Schedule
 * @package TaskBundle\Services
 */
class ScheduleHandler
{
    /** @var  EntityManager $em */
    private $em;
    /** @var  ApiResponseFormatter $responseFormatter */
    private $responseFormatter;
    /** @var  RecursiveValidator $validator */
    private $validator;

    public function __construct(EntityManager $em, ApiResponseFormatter $responseFormatter, RecursiveValidator $validator)
    {
        $this->em = $em;
        $this->responseFormatter = $responseFormatter;
        $this->validator = $validator;
    }

    public function getSchedule($date): Result
    {
        $result = new Result();
        $date = $this->getDateByString($date);
        if ($date === false) {
            return $result->addError(ErrorMessageHandler::INCORRECT_DATE_FORMAT)
                ->setIsSuccess(false);
        }

        $schedule = $this->em->getRepository('TaskBundle:Schedule')->findOneBy(['date' => $date]);
        if (is_null($schedule)) {
            return $result
                ->addError(ErrorMessageHandler::REQUESTED_DATA_NOT_EXISTS)
                ->setIsSuccess(false);

        }

        return $result->setData($schedule);
    }

    public function getSchedules(): Result
    {
        $result = new Result();
        $schedules = $this->em->getRepository('TaskBundle:Schedule')->findAll();

        return $result->setData($schedules);
    }

    public function createSchedule($date, $beginTime, $description, ?User $user): Result
    {
        $result = new Result();

        $date = $this->getDateByString($date);
        if ($date === false) {
            return $result->addError(ErrorMessageHandler::INCORRECT_DATE_FORMAT)
                ->setIsSuccess(false);
        }
        $startTime = $this->getDateByString($beginTime, 'H:i');
        if ($startTime === false) {
            return $result->addError(ErrorMessageHandler::INCORRECT_TIME_FORMAT)
                ->setIsSuccess(false);
        }
        $schedule = (new Schedule())
            ->setBeginTime($startTime)
            ->setDate($date)
            ->setDescription($description)
            ->setUser($user);

        $errors = $this->validator->validate($schedule);
        if (count($errors) > 0) {
            $result->setIsSuccess(false);
            foreach ($errors as $error) {
                //TODO: Вместо сообщений указывать коды ошибок
                $result->addError((int)$error);
            }
            return $result;
        }

        $this->em->persist($schedule);
        $this->em->flush();

        return $result->setData($schedule);
    }

    private function getDateByString($dateString, $format = 'dmY')
    {
        if (is_null($dateString)) {
            return new \DateTime();
        }

        return \DateTime::createFromFormat($format, $dateString);
    }
}