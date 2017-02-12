<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\ErrorResult;
use BaseBundle\Models\Result;
use BaseBundle\Models\SuccessResult;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Period;
use FOS\RestBundle\View\View;
use TaskBundle\Form\PeriodType;

class PeriodController extends BaseApiController
{
    /**
     * @Rest\View()
     * @param $periodId
     * @return Period
     */
    public function getPeriodAction($periodId = null)
    {
        $result = $this->get('period_handler')->getPeriodById($periodId);

        $result = $this->normalizePeriodResult($result);

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return
     */
    public function getPeriodsAction(Request $request)
    {
        $date = $request->request->get('date');
        $result = $this->get('period_handler')->getPeriods($date);
        $normalizedPeriods = $this->get('api_normalizer')->normalizePeriods($result->getData());

        return $this->getResponseByResultObj($result->setData($normalizedPeriods));
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return
     */
    public function postPeriodAction(Request $request)
    {
        $result = $this->fillEntityByRequest(new Period(), $request, PeriodType::class);
        if ($result->getIsSuccess()) {
            $result = $this->get('period_handler')->createPeriod($result->getData());
            $result = $this->normalizePeriodResult($result);
        }

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     * @param $periodId
     * @return View
     */
    public function deletePeriodAction($periodId)
    {
        $result = $this->get('period_handler')->deletePeriodById($periodId);
        $result = $this->normalizePeriodResult($result);

        return $this->getResponseByResultObj($result);
    }

    private function fillEntityByRequest($entity, Request $request, $type) : Result
    {
        $form = $this->createForm($type, $entity);
        $form->handleRequest($request);
        if (count($form->getErrors()) > 0) {
            $result = Result::createErrorResult();
            foreach ($form->getErrors(true) as $error) {
                /** @var FormError $error */
                $result->addError($error->getMessage());
            }

            return $result;
        }

        return Result::createSuccessResult($entity);
    }

    private function normalizePeriodResult(Result $result)
    {
        if (!is_null($result->getData())) {
            $normalizedPeriod = $this->get('api_normalizer')->conciseNormalizePeriod($result->getData());
            $result->setData($normalizedPeriod);
        }

        return $result;
    }
}
