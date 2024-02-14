<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

use App\Packages\ApiResponse\ApiResponseBuilder;
use App\Exceptions\BaseException;

use stdClass;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, \Throwable $exception)
    {
        $data = new stdClass();
        $data->file = $exception->getFile();
        $data->line = $exception->getLine();
        $data->trace = $exception->getTrace();

        if ($exception instanceof BaseException) {
            return ApiResponseBuilder::builder()
                ->withCode($exception->getResponseCode())
                ->withMessage($exception->getResponseMessage())
                ->withData($exception->getResponseContext())
                ->build();
        }

        return ApiResponseBuilder::builder()
            ->withCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->withMessage($exception->getMessage())
            ->withData($data)
            ->build();
    }
}
