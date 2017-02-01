<?php

namespace BaseBundle\Services;

use BaseBundle\Models\Result;
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

    protected function validateEntityAndGetResult($entity)
    {
        $errors = $this->validator->validate($entity);
        if (count($errors) > 0) {
            $errorCodes = [];
            foreach ($errors as $error) {
                //TODO: Вместо сообщений указывать коды ошибок
                $errorCodes[] = (int)$error;
            }
            return Result::createErrorResult($errorCodes);
        }

        $this->em->persist($entity);
        $this->em->flush();

        return Result::createSuccessResult($entity);
    }
}