<?php

namespace StoreBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use StoreBundle\Services\ReceiptHandler;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ReceiptController extends BaseApiController
{
    /**
     * @param Request $request
     * @Rest\View
     * @Rest\Get("create_by_qr_text")
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function createReceiptByQrTextAction(Request $request)
    {
        $queryParams = $request->query;
        $responseFormatter = $this->get('api_response_formatter')
            ->checkMandatoryParameters($queryParams, ['fn', 'i', 'fp', 't', 's']);
        if (!$responseFormatter->isSuccess()) {
            return $responseFormatter->createErrorResponse()->getResponse();
        }

        $result = $this->getHandler()
            ->saveByReceiptData($queryParams, $this->getUser());

        return $this->getResponseByResultObj($this->normalizeByResult($result));
    }

    /**
     * @Rest\View
     * @return array
     */
    public function getReceiptsAction()
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($criteria);
    }

    /**
     * @return ReceiptHandler
     */
    protected function getHandler(): EntityHandler
    {
        return $this->get('receipt_handler');
    }
}