<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
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
     * @param Request $request
     * @param $periodId
     * @return Period
     */
    public function getPeriodAction(Request $request, $periodId = null)
    {
        return $this->getEntityResultById($request, $periodId);
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

            return $this->getResponseByResultObj($result);
        }
        $expr = Criteria::expr()->eq('date', $date);

        return $this->getEntitiesByCriteria($request, (Criteria::create())->where($expr));
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function postPeriodAction(Request $request)
    {
        return $this->createEntity($request, Period::class, PeriodType::class);

    }

    /**
     * @Rest\View()
     * @param Request $request
     * @param $periodId
     * @return Result
     */
    public function putPeriodAction(Request $request, $periodId)
    {
        return $this->editEntity($request, $periodId, PeriodType::class);
    }

    /**
     * @Rest\View()
     * @param $periodId
     * @param Request $request
     * @return View
     */
    public function deletePeriodAction($periodId, Request $request)
    {
        return $this->removeEntityById($periodId, $request);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('period_handler');
    }
}
