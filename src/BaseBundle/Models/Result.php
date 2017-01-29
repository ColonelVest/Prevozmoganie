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
        return $this->data;
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