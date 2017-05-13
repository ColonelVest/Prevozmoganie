<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 13.05.17
 * Time: 21:16
 */

namespace TaskBundle\Controller;


use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class TaskEntryController extends BaseApiController
{
    /**
     * @Rest\View
     * @param Request $request
     * @param $entryId
     * @return array
     */
    public function getTaskentryAction(Request $request, $entryId)
    {
        return $this->getEntityResultById($request, $entryId);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function getTaskentriesAction(Request $request)
    {
        $date = null;
        if ($request->get('date')) {
            $date = $this->getDateFromRequest($request, 'date');
            if ($date === false) {
                $result = Result::createErrorResult(ErrorMessages::PERIOD_DATE_INCORRECT);

                return $this->getResponseByResultObj($result);
            }
        }
        $expr = Criteria::expr();
        $criteria = Criteria::create();
        $criteria->where($expr->andX($expr->eq('date', $date), $expr->eq('isCompleted', false)));

        return $this->getEntitiesByCriteria($request, $criteria);
    }
    
    protected function getHandler(): EntityHandler
    {
        return $this->get('task_entry_handler');
    }
}