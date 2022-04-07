<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Custom exception for model not found
     *
     * @param [type] $request
     * @param Throwable $exception
     * @return void
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $model = explode('\\', $exception->getModel());
            $message = end($model) . " not found.";

            // check json request
            if($request->wantsJson()) {
                return response()->json([
                    "message" => $message
                ], Response::HTTP_NOT_FOUND);
            } else {
                return $message;
            }
        }

        return parent::render($request, $exception);
    }
}
