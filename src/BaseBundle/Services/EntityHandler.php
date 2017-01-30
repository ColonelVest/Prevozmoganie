<?php

namespace BaseBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\RecursiveValidator;

abstract class EntityHandler
{
    /** @var  EntityManager $em */
    protected $em;
    /** @var  ApiResponseFormatter $responseFormatter */
    protected $responseFormatter;
    /** @var  RecursiveValidator $validator */
    protected $validator;

    public function __construct(EntityManager $em, ApiResponseFormatter $responseFormatter, RecursiveValidator $validator)
    {
        $this->em = $em;
        $this->responseFormatter = $responseFormatter;
        $this->validator = $validator;
    }
}