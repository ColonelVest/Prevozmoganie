<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\UserReferable;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\AbstractNormalizer;
use BaseBundle\Services\BaseHelper;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseApiController extends FOSRestController
{
    /** @var  EntityManager $em */
    protected $em;

    abstract protected function getHandler() : EntityHandler;
    abstract protected function getNormalizer() : AbstractNormalizer;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    protected function getEntityResultById($id, $isFullNormalized = true)
    {
        $result = $this->getHandler()->getById($id);

        return $this->getResponseByResultObj($this->normalizeByResult($result, $isFullNormalized));
    }

    protected function getEntitiesByCriteria(Criteria $criteria)
    {
        $result = $this->getHandler()->getEntities($criteria);
        $normalisedEntities = $this->getNormalizer()->conciseNormalizeEntities($result->getData());

        return $this->getResponseByResultObj(Result::createSuccessResult($normalisedEntities));
    }

    protected function removeEntityById($id, Request $request)
    {
        $checkTokenResult = $this->checkToken($request);
        $result = $this->getHandler()->removeById($id, $checkTokenResult->getData());

        return $this->getResponseByResultObj($result);
    }

    protected function createEntity(Request $request, $entityType, $entityForm, $withUser = false)
    {
        $result = $this->fillEntityByRequest(new $entityType(), $request, $entityForm, $withUser);
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
            $result = $this->fillEntityByRequest($result->getData(), $request, $entityForm);
            if ($result->getIsSuccess()) {
                $result = $handler->edit($result->getData());
                $result = $this->normalizeByResult($result, true);
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
        return BaseHelper::createDateFromString($request->get($propertyName), $format);
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
     * @param $type
     * @param bool $setUser
     * @return Result
     */
    protected function fillEntityByRequest($entity, Request $request, $type, $setUser = false) : Result
    {
        if ($setUser && $entity instanceof UserReferable) {
            $userResult = $this->getRequestUser($request);
            if (!$userResult->getIsSuccess()) {
                return $userResult;
            }
            //TODO: Мб добавить интерфейс и проверку на него
            $entity->setUser($userResult->getData());
        }

        $form = $this->createForm($type, $entity);
        $form->submit($request->get($form->getName()));
        if (!$form->isValid()) {

            $result = Result::createErrorResult();
            foreach ($form->getErrors(true) as $error) {
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

    private function normalizeByResult(Result $result, $isFullNormalization = false)
    {
        if (!is_null($result->getData())) {
            $normalizer = $this->getNormalizer();
            if ($isFullNormalization) {
                $normalizedPeriod = $normalizer->fullNormalize($result->getData());
            } else {
                $normalizedPeriod = $normalizer->conciseNormalize($result->getData());
            }
            $result->setData($normalizedPeriod);
        }

        return $result;
    }
}