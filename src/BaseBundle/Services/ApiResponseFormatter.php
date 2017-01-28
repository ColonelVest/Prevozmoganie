<?php

namespace BaseBundle\Services;

class ApiResponseFormatter
{
    private $isSuccess;
    private $response;

    const REQUESTED_DATA_NOT_EXISTS = [1 => 'not_exist'];
    const INCORRECT_DATE_FORMAT = [2 => 'incorrect_date'];

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

    public function addResponseMessage(array $message, $messageType = null)
    {
        $messageType = $messageType ? $messageType : ($this->isSuccess ? 'Warnings' : 'Errors');
        $this->response[$messageType][] = $message;

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
            ->addResponseMessage(self::REQUESTED_DATA_NOT_EXISTS)
            ->getResponse();
    }

    public function getResponse()
    {
        return $this->response;
    }
}