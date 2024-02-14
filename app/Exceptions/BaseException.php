<?php

namespace App\Exceptions;

use Exception;

use stdClass;

class BaseException extends Exception
{
    static $responseCode;
    static $responseMessage;
    static $responseContext;

    public function __construct(
        int $responseCode,
        string $responseMessage,
        string $responseContext,
    ) {
        self::$responseCode = $responseCode;
        self::$responseMessage = $responseMessage;
        self::$responseContext = $responseContext;
    }

    public function getResponseCode(){
        return self::$responseCode;
    }

    public function getResponseMessage(){
       return self::$responseMessage;
    }

    public function getResponseContext(){
        $data = new stdClass();
        $data->error = self::$responseContext;
        return $data;
    }
}
