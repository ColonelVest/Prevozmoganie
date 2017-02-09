<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\Result;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Period;
use FOS\RestBundle\View\View;

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

        $result = $this->normalizePeriod($result);

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     */
    public function getPeriodsAction()
    {
        $result = $this->get('period_handler')->getPeriods();
        $normalizedPeriods = $this->get('api_normalizer')->normalizePeriods($result->getData());

        return $this->getResponseByResultObj($result->setData($normalizedPeriods));
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @param $date
     * @return
     */
    public function postPeriodAction(Request $request, $date)
    {
        $result = $this->get('schedule_handler')->getScheduleByDateString($date);
        if ($result->getIsSuccess()) {
            $begin = $request->request->get('begin');
            $end = $request->request->get('end');
            $description = $request->request->get('description');
            $result = $this->get('period_handler')->createPeriod($result->getData(), $begin, $end, $description);
            $result = $this->normalizePeriod($result);
        }

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     * @param $periodId
     * @param $date
     * @return View
     */
    public function deleteSchedulePeriodAction($date, $periodId)
    {
        $result = $this->get('period_handler')->deletePeriodById($periodId, $date);

        return $this->getResponseByResultObj($result);
    }

    private function normalizePeriod(Result $result)
    {
        if (!is_null($result->getData())) {
            $normalizedPeriod = $this->get('api_normalizer')->conciseNormalizePeriod($result->getData());
            $result->setData($normalizedPeriod);
        }

        return $result;
    }
}
