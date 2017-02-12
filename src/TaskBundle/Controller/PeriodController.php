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
        $begin = $request->request->get('begin');
        $end = $request->request->get('end');
        $description = $request->request->get('description');
        $user = $this->getUser();
        $date = \DateTime::createFromFormat('dmY', $request->request->get('date'));
        $result = $this->get('period_handler')->createPeriod($user, $date, $begin, $end, $description);
        $result = $this->normalizePeriod($result);

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     * @param $periodId
     * @param $date
     * @return View
     */
    public function deletePeriodAction($periodId)
    {
        $result = $this->get('period_handler')->deletePeriodById($periodId);
        $result = $this->normalizePeriod($result);

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
