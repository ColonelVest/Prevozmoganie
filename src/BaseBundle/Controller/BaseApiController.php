<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\UserReferable;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use BaseBundle\Services\PVNormalizer;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseApiController extends FOSRestController implements TokenAuthenticatedController
{
    /** @var  EntityManager $em */
    protected $em;
    /** @var  PVNormalizer $normalizer */
    protected $normalizer;

    abstract protected function getHandler(): EntityHandler;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->normalizer = $this->get('pv_normalizer');
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    protected function getEntityResultById(Request $request, $id, $isFullNormalized = true)
    {
        $result = $this->checkToken($request);
        if ($result->getIsSuccess()) {
            $user = $result->getData();
            $result = $this->getHandler()->getById($id);

            if ($result->getIsSuccess()
                && $result->getData() instanceOf UserReferable
                && $result->getData()->getUser() != $user
            ) {
                $result = Result::createErrorResult(ErrorMessages::PERMISSION_DENIED);
            }
        }

        return $this->getResponseByResultObj($this->normalizeByResult($result, $isFullNormalized));
    }

    protected function getEntitiesByCriteria(Request $request, Criteria $criteria, $byUser = true)
    {
        $result = $this->checkToken($request);
        if ($result->getIsSuccess()) {
            $user = $result->getData();
            if ($byUser) {
                $criteria->andWhere(Criteria::expr()->eq('user', $user));
            }
            $result = $this->getHandler()->getEntities($criteria);
            if ($result->getIsSuccess()) {
                $normalisedEntities = $this->normalizer->normalizeNestedEntities($result->getData());
                $result = Result::createSuccessResult($normalisedEntities);
            }
        }

        return $this->getResponseByResultObj($result);
    }

    protected function removeEntityById($id, Request $request)
    {
        $result = $this->checkToken($request);
        if ($result->getIsSuccess()) {
            $user = $result->getData();
            $result = $this->getHandler()->removeById($id, $user);
        }

        return $this->getResponseByResultObj($result);
    }

    protected function createEntity(Request $request, $entityType, $entityName, $withUser = true)
    {
        $result = $this->fillEntityByRequest(new $entityType(), $request, $entityName, $withUser);
        if ($result->getIsSuccess()) {
            $result = $this->getHandler()->create($result->getData());
            $result = $this->normalizeByResult($result, true);
        }

        return $this->getResponseByResultObj($result);
    }

    protected function editEntity(Request $request, $entityId, $entityForm)
    {
        $result = $this->checkToken($request);
        if ($result->getIsSuccess()) {
            $user = $result->getData();
            $handler = $this->getHandler();
            $result = $this->getHandler()->getById($entityId);
            if ($result->getIsSuccess()) {
                if ($result->getData() instanceof UserReferable && $result->getData()->getUser() == $user) {
                    $result = $this->fillEntityByRequest($result->getData(), $request, $entityForm);
                    if ($result->getIsSuccess()) {
                        $result = $handler->edit($result->getData());
                        $result = $this->normalizeByResult($result, true);
                    }
                } else {
                    $result = Result::createErrorResult(ErrorMessages::PERMISSION_DENIED);
                }
            }
        }

        return $this->getResponseByResultObj($result);
    }

    protected function getResponseByResultObj(Result $result)
    {
        return $this->get('api_response_formatter')->createResponseFromResultObj($result);
    }

    protected function getDateFromRequest(Request $request, $propertyName, $format = 'dmY')
    {
        return $this->get('base_helper')->createDateFromString($request->get($propertyName), $format);
    }

    public function checkToken(Request $request)
    {
        $result = $this->getToken($request);
        if (!$result->getIsSuccess()) {
            return $result;
        }

        return $this->get('token_handler')->isTokenCorrect($result->getData());
    }

    /**
     * Заполняет сушность данными из запроса с помощью формы
     *
     * @param $entity
     * @param Request $request
     * @param $entityName
     * @param bool $setUser
     * @param array $unMappedFields
     * @return Result
     */
    protected function fillEntityByRequest($entity, Request $request, $entityName, $setUser = false, $unMappedFields = []): Result
    {
        if ($setUser && $entity instanceof UserReferable) {
            $userResult = $this->getRequestUser($request);
            if (!$userResult->getIsSuccess()) {
                return $userResult;
            }
            $entity->setUser($userResult->getData());
        }
        $this->get('pv_normalizer')->fillEntity($entity, $request->get($entityName), $unMappedFields);
        if (!($errors = $this->get('validator')->validate($entity))) {
            $result = Result::createErrorResult();
            foreach ($errors as $error) {
                /** @var FormError $error */
                $message = $error->getMessage();
                $result->addError(intval($message));
            }

            return $result;
        }

        return Result::createSuccessResult($entity);
    }

    protected function getToken(Request $request)
    {
        $token = $request->get('token');
        if (is_null($token)) {
            return Result::createErrorResult(ErrorMessages::NOT_AUTHORIZED);
        }

        return Result::createSuccessResult($token);
    }

    protected function getRequestUser(Request $request)
    {
        $result = $this->getToken($request);
        if (!$result->getIsSuccess()) {
            return $result;
        }

        return $this->get('token_handler')->getUserByToken($result->getData());
    }

    protected function normalizeByResult(Result $result, $isFullNormalization = false)
    {
        if (!is_null($result->getData())) {
            if ($isFullNormalization) {
                $normalizedPeriod = $this->normalizer->fullNormalize($result->getData());
            } else {
                $normalizedPeriod = $this->normalizer->normalizeNested($result->getData());
            }
            $result->setData($normalizedPeriod);
        }

        return $result;
    }
}