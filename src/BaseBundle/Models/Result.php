<?php

namespace BaseBundle\Models;

/**
 * Модель для хранения абстрактных результатов функций
 * Class Result
 * @package BaseBundle\Models
 */
class Result
{
    /** @var  bool $isSuccess */
    private $isSuccess = true;
    /** @var array $errors */
    private $errors = [];
    private $data;

    public static function createSuccessResult($data = null)
    {
        $result = new self();
        if ($data) {
            $result->setData($data);
        }

        return $result;
    }

    public static function createErrorResult($errorData = null)
    {
        $result = new Result();
        if (!is_null($errorData)) {
            if (is_array($errorData)) {
                if (count($errorData) > 0) {
                    foreach ($errorData as $error) {
                        $result->addError($error);
                    }
                }
            } else {
                $result->addError($errorData);
            }
        }

        return $result->setIsSuccess(false);
    }

    /**
     * @return mixed
     */
    public function getIsSuccess()
    {
        return $this->isSuccess;
    }

    /**
     * @param mixed $isSuccess
     * @return Result
     */
    public function setIsSuccess($isSuccess): Result
    {
        $this->isSuccess = $isSuccess;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param $errorCode
     * @return Result
     */
    public function addError($errorCode): Result
    {
        $this->errors[] = $errorCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        if ($this->isSuccess) {
            return $this->data;
        }

        return null;
    }

    /**
     * @param mixed $data
     * @return Result
     */
    public function setData($data): Result
    {
        $this->data = $data;

        return $this;
    }

}