<?php

namespace BaseBundle\Controller;

use BaseBundle\Models\Result;
use FOS\RestBundle\Controller\FOSRestController;

class BaseApiController extends FOSRestController
{
    protected function getResponseByResultObj(Result $result)
    {
        return $this->get('api_response_formatter')->createResponseFromResultObj($result);
    }
}