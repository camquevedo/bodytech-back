<?php

namespace App\Packages\ApiResponse\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use stdClass;

class ApiResponse implements ApiResponseInterface
{
    const UNKNOWN_ERROR = 'UNKNOWN_ERROR';

    protected $code = Response::HTTP_OK;
    protected $message = '';
    protected $data = [];
    protected $pagination = null;

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code)
    {
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getPagination()
    {
        return $this->pagination ?? null;
    }

    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    public function toJson(): JsonResponse
    {
        $response = new stdClass();
        $response->code = $this->code;
        $response->message = $this->message;
        $response->data = empty($this->data) ? null : $this->data;
        $response->pagination = empty($this->pagination) ? null : $this->pagination;

        return response()->json($response, $this->code);
    }
}
