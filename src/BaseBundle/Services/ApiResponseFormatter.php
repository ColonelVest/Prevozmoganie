<?php

namespace BaseBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use Symfony\Component\HttpFoundation\ParameterBag;

class ApiResponseFormatter
{
    /** @var  bool $isSuccess */
    private $isSuccess = true;
    private $response;
    /** @var  ErrorMessages $messageHandler */
    private $messageHandler;

    public function __construct(ErrorMessages $messageHandler)
    {
        $this->messageHandler = $messageHandler;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->isSuccess;
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

    /**
     * @param $errorCode
     * @param array $params
     * @param null $messageType
     * @return ApiResponseFormatter
     */
    public function addResponseMessage($errorCode, $params = [], $messageType = null)
    {
        $messageType = $messageType ? $messageType : ($this->isSuccess ? 'warnings' : 'errors');
        $this->response[$messageType][] = is_int($errorCode) ? $this->messageHandler->getErrorMessageByCode($errorCode, $params) : $errorCode;

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

    /**
     * @param ParameterBag $bag
     * @param array $params
     * @return ApiResponseFormatter
     */
    public function checkMandatoryParameters(ParameterBag $bag, array $params)
    {
        foreach ($params as $paramName) {
            if (!$bag->has($paramName)) {
                $this->addResponseMessage(ErrorMessages::MANDATORY_PARAM_IS_MISSING, ['%paramName%' => $paramName]);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }
}