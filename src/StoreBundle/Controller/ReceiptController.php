<?php

namespace StoreBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use StoreBundle\Services\ReceiptHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ReceiptController extends BaseApiController
{
    /**
     * @param Request $request
     * @Rest\View
     * @Rest\Get("create_by_qr_text")
     * @return JsonResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createReceiptByQrTextAction(Request $request)
    {
        $queryParams = $request->query;
        $response = $this->get('store_http')->getReceiptDetails($queryParams->get('fn'), $queryParams->get('i'), $queryParams->get('fp'));
        $fmsData = json_decode((string)$response->getBody(), true);
        $receiptResult = $this->getHandler()->saveByFMSData($fmsData, $this->getUser());

        return $this->normalizeByResult($receiptResult, true);
    }

    /**
     * @return ReceiptHandler
     */
    protected function getHandler(): EntityHandler
    {
        return $this->get('receipt_handler');
    }
}