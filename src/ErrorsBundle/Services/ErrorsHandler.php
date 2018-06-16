<?php

namespace ErrorsBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;

class ErrorsHandler extends EntityHandler
{
    protected $notExistsMessage = ErrorMessages::REQUESTED_ERROR_NOT_EXISTS;

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('ErrorsBundle:Error');
    }
}