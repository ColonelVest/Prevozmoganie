<?php

namespace BaseBundle\Services;

use BaseBundle\Models\ErrorMessageHandler;
use BaseBundle\Models\Result;

class ApiResponseFormatter
{
    /** @var  bool $isSuccess */
    private $isSuccess;
    private $response;
    /** @var  ErrorMessageHandler $messageHandler */
    private $messageHandler;

    public function __construct(ErrorMessageHandler $messageHandler)
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
            'success' => $isSuccess
        ];

        return $this;
    }

    public function addResponseMessage(int $errorCode, $messageType = null)
    {
        $messageType = $messageType ? $messageType : ($this->isSuccess ? 'Warnings' : 'Errors');
        $this->response[$messageType][] = $this->messageHandler->getErrorMessageByCode($errorCode);

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

    public function createResponseFromResultObj(Result $result)
    {
        $this->createResponse($result->getIsSuccess());
        foreach ($result->getErrors() as $error) {
            $this->addResponseMessage($error);
        }
        if ($result->getData()) {
            $this->setResponseData($result->getData());
        }

        return $this->getResponse();
    }

    public function getResponse()
    {
        return $this->response;
    }
}