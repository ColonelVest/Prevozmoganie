<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 18/06/2017
 * Time: 16:01
 */

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Challenge;

class ChallengeController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $challengeId
     * @return array
     */
    public function getChallengeAction($challengeId)
    {
        return $this->getEntityResultById($challengeId);
    }

    /**
     * @Rest\View
     * @return array
     */
    public function getChallengesAction()
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($criteria);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function postChallengesAction(Request $request)
    {
        return $this->createEntity(Challenge::class, $request);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $challengeId
     * @return array
     */
    public function putChallengesAction(Request $request, $challengeId)
    {
        return $this->editEntity($request, $challengeId);
    }

    /**
     * @Rest\View
     * @param $challengeId
     * @return array
     */
    public function deleteChallengeAction($challengeId)
    {
        return $this->removeEntityById($challengeId);
    }

    /**
     * @return EntityHandler
     */
    protected function getHandler(): EntityHandler
    {
        return $this->get('challenge_handler');
    }
}