<?php

namespace BaseBundle\Models;


class Result
{
    /** @var  bool $isSuccess */
    private $isSuccess;
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
    public function setIsSuccess($isSuccess)
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
     * @param $error
     * @return Result
     */
    public function addError($error): Result
    {
        $this->errors[] = $error;

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
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

}