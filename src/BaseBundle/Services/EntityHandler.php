<?php

namespace BaseBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use UserBundle\Entity\User;

abstract class EntityHandler
{
    /** @var  EntityManager $em */
    protected $em;
    /** @var  ApiResponseFormatter $responseFormatter */
    protected $responseFormatter;
    /** @var  RecursiveValidator $validator */
    protected $validator;
    protected $notExistsMessage = ErrorMessages::REQUESTED_DATA_NOT_EXISTS;
    const DATE_FORMAT = 'dmY';

    public function __construct(
        EntityManager $em,
        ApiResponseFormatter $responseFormatter,
        RecursiveValidator $validator
    ) {
        $this->em = $em;
        $this->responseFormatter = $responseFormatter;
        $this->validator = $validator;
    }

    public function getById($id)
    {
        $entity = $this->getRepository()->find($id);
        if (is_null($entity)) {
            return Result::createErrorResult([$this->notExistsMessage]);
        }

        return Result::createSuccessResult($entity);
    }

    public function getEntities(Criteria $criteria)
    {
        $entities = $this->getRepository()->matching($criteria)->getValues();

        return Result::createSuccessResult($entities);
    }

    public function remove(BaseEntity $entity)
    {
        $id = $entity->getId();
        $this->em->remove($entity);
        $this->em->flush();

        return Result::createSuccessResult($id);
    }

    public function removeById($id, User $user)
    {
        $result = $this->getById($id);
        if ($result->getIsSuccess()) {
            return $this->remove($result->getData());
        }

        return $result;
    }

    public function create(BaseEntity $entity): Result
    {
        return $this->validateEntityAndGetResult($entity);
    }

    public function edit(BaseEntity $entity): Result
    {
        return $this->validateEntityAndGetResult($entity);
    }

    protected function validateEntityAndGetResult($entity)
    {
        $errors = $this->validator->validate($entity);
        if (count($errors) > 0) {
            $errorCodes = [];
            foreach ($errors as $error) {
                $errorCodes[] = (int)$error;
            }

            return Result::createErrorResult($errorCodes);
        }

        $this->em->persist($entity);
        $this->em->flush();

        return Result::createSuccessResult($entity);
    }

    abstract protected function getRepository(): EntityRepository;
}