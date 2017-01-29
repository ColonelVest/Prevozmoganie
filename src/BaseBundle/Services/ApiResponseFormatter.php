<?php

namespace BaseBundle\Services;

use BaseBundle\Models\ErrorsEnum;
use BaseBundle\Models\Result;

class ApiResponseFormatter
{
    /** @var  bool $isSuccess */
    private $isSuccess;
    private $response;

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
        $this->response[$messageType][] = ErrorsEnum::getErrorMessageByCode($errorCode);

        return $this;
    }

    public function addResponseData($data, $title = null)
    {
        $title ? $this->response['data'][$title] = $data : $this->response['data'][] = $data;

        return $this;
    }

    public function getDataNotExistsResponse()
    {
        return $this->createErrorResponse()
            ->addResponseMessage(ErrorsEnum::REQUESTED_DATA_NOT_EXISTS)
            ->getResponse();
    }

    public function createResponseFromResultObj(Result $result)
    {
        $this->createResponse($result->getIsSuccess());
        foreach ($result->getErrors() as $error) {
            $this->addResponseMessage($error);
        }
        if ($result->getData()) {
            $this->addResponseData($result->getData());
        }

        return $this->getResponse();
    }

    public function getResponse()
    {
        return $this->response;
    }
}