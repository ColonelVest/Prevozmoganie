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
use TaskBundle\Entity\TaskEntry;
use TaskBundle\Form\TaskEntryType;

class TaskEntryController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $entryId
     * @return array
     */
    public function getTaskentryAction($entryId)
    {
        return $this->getEntityResultById($entryId);
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

        return $this->getEntitiesByCriteria($criteria);
    }

    /**
     * @Rest\View
     * @Rest\Put("/taskentries/confirm/{id}")
     *
     * @param TaskEntry $entry
     *
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function confirmAction(TaskEntry $entry)
    {
        $this->getHandler()->edit($entry->setIsCompleted(true));
        $this->em->flush();

        $normalizedEntry = $this->serializer->fullNormalize($entry);
        return $this->getResponseByResultObj(Result::createSuccessResult($normalizedEntry));
    }

    /**
     * @Rest\View
     *
     * @param Request $request
     *
     * @return array
     * @throws \BaseBundle\Lib\Serialization\NormalizationException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postTaskentriesAction(Request $request)
    {
        return $this->createEntity($request, TaskEntry::class);
    }

    /**
     * @Rest\View
     *
     * @param $taskEntryId
     *
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteTaskentryAction($taskEntryId)
    {
        return $this->removeEntityById($taskEntryId);
    }

    /**
     * @Rest\View
     *
     * @param Request $request
     * @param         $taskEntryId
     *
     * @return array
     * @throws \BaseBundle\Lib\Serialization\NormalizationException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \ReflectionException
     */
    public function putTaskentriesAction(Request $request, $taskEntryId)
    {
        return $this->editEntity($request, $taskEntryId);
    }
    
    protected function getHandler(): EntityHandler
    {
        return $this->get('task_entry_handler');
    }
}
