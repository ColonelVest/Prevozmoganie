<?php

namespace TaskBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use TaskBundle\Entity\Period;

class PeriodController extends FOSRestController
{
    /**
     * @Rest\View()
     * @param Period $period
     * @return Period
     */
    public function getPeriodAction(Period $period)
    {
        return $period;
    }

    /**
     * @Rest\View()
     */
    public function getPeriodsAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('TaskBundle:Period')->findAll();
    }
}
