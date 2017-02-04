<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Period;
use TaskBundle\Entity\Schedule;
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

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     */
    public function getPeriodsAction()
    {
        $result = $this->get('period_handler')->getPeriods();

        return $this->getResponseByResultObj($result);
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
            $duration = $request->request->get('duration');
            $description = $request->request->get('description');
            $result = $this->get('period_handler')->createPeriod($result->getData(), $duration, $description);
        }

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     * @param $periodId
     * @param $date
     * @return View
     */
    public function deleteSchedulePeriodAction($periodId, $date)
    {
        $result =  $this->get('period_handler')->deletePeriod($date, $periodId);

        return $this->getResponseByResultObj($result);
    }
}
