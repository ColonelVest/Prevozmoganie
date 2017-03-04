<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiNormalizer;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use FOS\RestBundle\Controller\Annotations as Rest;
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
        return $this->getEntityResultById($periodId);
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
            $normalizedPeriods = $this->get('period_normalizer')->normalizePeriods($result->getData());
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
     * @param Request $request
     * @param $periodId
     * @return Result
     */
    public function putPeriodAction(Request $request, $periodId)
    {
        $periodHandler = $this->get('period_handler');
        $result = $periodHandler->getPeriodById($periodId);
        if ($result->getIsSuccess()) {
            $result = $this->fillEntityByRequest($result->getData(), $request, PeriodType::class);
            if ($result->getIsSuccess()) {
                $result = $periodHandler->editPeriod($result->getData());
            }
        }

        return $result;
    }

    /**
     * @Rest\View()
     * @param $periodId
     * @return View
     */
    public function deletePeriodAction($periodId)
    {
        $result = $this->get('period_handler')->deletePeriodById($periodId);

        return $this->getResponseByResultObj($result);
    }

    private function normalizePeriodResult(Result $result)
    {
        if (!is_null($result->getData())) {
            $normalizedPeriod = $this->get('api_normalizer')->conciseNormalizePeriod($result->getData());
            $result->setData($normalizedPeriod);
        }

        return $result;
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('period_handler');
    }

    protected function getNormalizer(): ApiNormalizer
    {
        return $this->get('period_normalizer');
    }
}
