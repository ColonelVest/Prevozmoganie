<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @return array
     */
    public function getPeriodsAction(Request $request)
    {
        $date = $this->getDateFromRequest($request, 'date');
        if ($date === false) {
            $result = Result::createErrorResult(ErrorMessages::PERIOD_DATE_INCORRECT);
        } else {
            $result = $this->get('period_handler')->getPeriods($date);
            $normalizedPeriods = $this->get('api_normalizer')->normalizePeriods($result->getData());
            $result->setData($normalizedPeriods);
        }

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function postPeriodAction(Request $request)
    {
        $result = $this->fillEntityByRequest(new Period(), $request, PeriodType::class);
        if ($result->getIsSuccess()) {
            $result->getData()->setUser($this->getUser());
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
        $form->submit($request->request->all());
        if (!$form->isValid()) {
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
