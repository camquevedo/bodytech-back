<?php

namespace App\Packages\ApiResponse;

use App\Packages\ApiResponse\Contracts\ApiResponse;

class ApiResponseBuilder extends ApiResponse
{
    /**
     * Instanciate the class
     * @return App\Packages\ApiResponse\ApiResponseBuilder
     */
    public static function builder()
    {
        return new ApiResponseBuilder();
    }

    /**
     * Get json response
     */
    public function build()
    {
        $this->setCode($this->getCode());
        $this->setMessage($this->getMessage());
        $this->setData($this->getData());
        $this->setPagination($this->getPagination());
        return $this->toJson();
    }

    /**
     * Set http code response
     * @param int $code
     * @return App\Packages\ApiResponse\ApiResponseBuilder
     */
    public function withCode(int $code): ApiResponseBuilder
    {
        $this->setCode($code);
        return $this;
    }

    /**
     * Set message response
     * @param string $message
     * @return App\Packages\ApiResponse\ApiResponseBuilder
     */
    public function withMessage(string $message): ApiResponseBuilder
    {
        $this->setMessage($message);
        return $this;
    }

    /**
     * Set data response
     * @return App\Packages\ApiResponse\ApiResponseBuilder
     */
    public function withData($data): ApiResponseBuilder
    {
        $this->setData($data);
        return $this;
    }

    /**
     * Set pagination
     * @return App\Packages\ApiResponse\ApiResponseBuilder
     */
    public function withPagination($pagination): ApiResponseBuilder
    {
        $this->setPagination($pagination);
        return $this;
    }
}
