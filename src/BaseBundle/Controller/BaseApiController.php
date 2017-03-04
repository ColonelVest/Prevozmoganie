<?php

namespace BaseBundle\Controller;

use BaseBundle\Models\Result;
use BaseBundle\Services\ApiNormalizer;
use BaseBundle\Services\BaseHelper;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseApiController extends FOSRestController
{
    abstract protected function getHandler() : EntityHandler;
    abstract protected function getNormalizer() : ApiNormalizer;

    protected function getEntityResultById($id)
    {
        $result = $this->getHandler()->getById($id);

        return $this->getResponseByResultObj($this->normalizeByResult($result));
    }

    protected function getEntitiesByCriteria(Criteria $criteria)
    {
        $result = $this->getHandler()->getEntities($criteria);
        $normalisedEntities = $this->getNormalizer()->conciseNormalizeEntities($result->getData());

        return $this->getResponseByResultObj(Result::createSuccessResult($normalisedEntities));
    }

    protected function removeEntityById($id)
    {
        $result = $this->getHandler()->removeById($id);

        return $this->getResponseByResultObj($result);
    }

    protected function createEntity(Request $request, $entityType, $entityForm)
    {
        $result = $this->fillEntityByRequest(new $entityType(), $request, $entityForm);
        if ($result->getIsSuccess()) {
            $result = $this->getHandler()->create($result->getData());
            $result = $this->normalizeByResult($result);
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
                $result = $this->normalizeByResult($result);
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

    /**
     * Заполняет сушность данными из запроса с помощью формы
     *
     * @param $entity
     * @param Request $request
     * @param $type
     * @return Result
     */
    protected function fillEntityByRequest($entity, Request $request, $type) : Result
    {
        $form = $this->createForm($type, $entity);
        $form->submit($request->request->all());
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

    private function normalizeByResult(Result $result)
    {
        if (!is_null($result->getData())) {
            $normalizedPeriod = $this->getNormalizer()->conciseNormalize($result->getData());
            $result->setData($normalizedPeriod);
        }

        return $result;
    }
}