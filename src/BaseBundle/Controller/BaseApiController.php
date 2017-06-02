<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\UserReferable;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use BaseBundle\Services\PVSerializer;
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
    /** @var  PVSerializer $serializer */
    protected $serializer;

    abstract protected function getHandler(): EntityHandler;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->serializer = $this->get('pv_serializer');
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    protected function getEntityResultById($id, $isFullNormalized = true)
    {
        $result = $this->getHandler()->getById($id);

        if ($result->getIsSuccess()
            && $result->getData() instanceOf UserReferable
            && $result->getData()->getUser() != $this->getUser()
        ) {
            $result = Result::createErrorResult(ErrorMessages::PERMISSION_DENIED);
        }

        return $this->getResponseByResultObj($this->normalizeByResult($result, $isFullNormalized));
    }

    protected function getEntitiesByCriteria(Criteria $criteria, $byUser = true)
    {
        $user = $this->getUser();
        if ($byUser) {
            $criteria->andWhere(Criteria::expr()->eq('user', $user));
        }
        $result = $this->getHandler()->getEntities($criteria);
        if ($result->getIsSuccess()) {
            $normalisedEntities = $this->serializer->normalizeNestedEntities($result->getData());
            $result = Result::createSuccessResult($normalisedEntities);
        }

        return $this->getResponseByResultObj($result);
    }

    protected function removeEntityById($id)
    {
        $result = $this->getHandler()->removeById($id, $this->getUser());

        return $this->getResponseByResultObj($result);
    }

    protected function createEntity($entityType, Request $request)
    {
        $newEntity = new $entityType();
        $entityName = strtolower((new \ReflectionClass($newEntity))->getShortName());
        $requestData = $request->request->get($entityName);
        $result = $this->fillEntityByRequestData($newEntity, $requestData);
        if ($result->getIsSuccess()) {
            $result = $this->getHandler()->create($result->getData());
            $result = $this->normalizeByResult($result, true);
        }

        return $this->getResponseByResultObj($result);
    }

    protected function editEntity(Request $request, $entityId, $entityForm)
    {
        $handler = $this->getHandler();
        $result = $this->getHandler()->getById($entityId);
        if ($result->getIsSuccess()) {
            if ($result->getData() instanceof UserReferable && $result->getData()->getUser() == $this->getUser()) {
                $result = $this->fillEntityByRequestData($result->getData(), $request, $entityForm);
                if ($result->getIsSuccess()) {
                    $result = $handler->edit($result->getData());
                    $result = $this->normalizeByResult($result, true);
                }
            } else {
                $result = Result::createErrorResult(ErrorMessages::PERMISSION_DENIED);
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

    /**
     * Заполняет сушность данными из запроса с помощью формы
     *
     * @param $entity
     * @param $requestData
     * @param array $unMappedFields
     * @return Result
     */
    protected function fillEntityByRequestData($entity, $requestData, $unMappedFields = []): Result {
        if ($entity instanceof UserReferable) {
            $entity->setUser($this->getUser());
        }
        $this->get('pv_normalizer')->fillEntity($entity, $requestData, $unMappedFields);
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

    protected function normalizeByResult(Result $result, $isFullNormalization = false)
    {
        if (!is_null($result->getData())) {
            if ($isFullNormalization) {
                $normalizedPeriod = $this->serializer->fullNormalize($result->getData());
            } else {
                $normalizedPeriod = $this->serializer->normalizeNested($result->getData());
            }
            $result->setData($normalizedPeriod);
        }

        return $result;
    }
}