<?php

namespace BaseBundle\Controller;

use BaseBundle\Models\Result;
use BaseBundle\Services\BaseHelper;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class BaseApiController extends FOSRestController
{
    protected function getResponseByResultObj(Result $result)
    {
        return $this->get('api_response_formatter')->createResponseFromResultObj($result);
    }

    protected function getDateFromRequest(Request $request, $propertyName, $format = 'dmY')
    {
        return BaseHelper::createDateFromString($request->get($propertyName), $format);
    }
}