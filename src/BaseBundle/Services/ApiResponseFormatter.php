<?php

namespace BaseBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;

class ApiResponseFormatter
{
    /** @var  bool $isSuccess */
    private $isSuccess;
    private $response;
    /** @var  ErrorMessages $messageHandler */
    private $messageHandler;

    public function __construct(ErrorMessages $messageHandler)
    {
        $this->messageHandler = $messageHandler;
    }

    public function createSuccessResponse()
    {
        return $this->createResponse(true);
    }

    public function createErrorResponse()
    {
        return $this->createResponse(false);
    }

    private function createResponse(bool $isSuccess)
    {
        $this->isSuccess = $isSuccess;
        $this->response = [
            'success' => $isSuccess,
        ];

        return $this;
    }

    public function addResponseMessage($errorCode, $messageType = null)
    {
        $messageType = $messageType ? $messageType : ($this->isSuccess ? 'warnings' : 'errors');
        $this->response[$messageType][] = is_int($errorCode) ? $this->messageHandler->getErrorMessageByCode($errorCode) : $errorCode;

        return $this;
    }

    public function addResponseData($data, $title = null)
    {
        $title ? $this->response['data'][$title] = $data : $this->response['data'][] = $data;

        return $this;
    }

    public function setResponseData($data)
    {
        $this->response['data'] = $data;

        return $this;
    }

    public function createResponseFromResultObj(Result $result) : array
    {
        $this->createResponse($result->getIsSuccess());
        foreach ($result->getErrors() as $error) {
            $this->addResponseMessage($error);
        }
        if (!is_null($result->getData())) {
            $this->setResponseData($result->getData());
        }

        return $this->getResponse();
    }

    public function getResponse()
    {
        return $this->response;
    }
}