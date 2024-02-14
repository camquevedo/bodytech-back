<?php

namespace App\Packages\ApiResponse\Contracts;

use Illuminate\Http\JsonResponse;

interface ApiResponseInterface
{
    /**
     * Get the http code
     * @return int
     */
    public function getCode(): int;

    /**
     * Set the http code
     * @param int $code
     */
    public function setCode(int $code);

    /**
     * Get response message
     * @return string
     */
    public function getMessage(): string;

    /**
     * Set response message
     * @param string $message
     */
    public function setMessage(string $message);

    /**
     * Get response data
     * @return object
     */
    public function getData();

    /**
     * Set response data
     * @param object $data
     */
    public function setData($data);

    /**
     * Get pagination
     * @return $pagination
     */
    public function getPagination();

    /**
     * Set pagination
     * @param object $pagination
     */
    public function setPagination($pagination);

    public function toJson(): JsonResponse;
}
