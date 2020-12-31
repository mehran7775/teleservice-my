<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\This;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()){

           if ($exception instanceof ValidationException){
               return $this->renderValidationException($request,$exception);
           }
           if ($exception instanceof AuthenticationException){
                return $this->renderAuthenticationException($request,$exception);
           }
            return $this->renderOtherExceptions($request,$exception);

        }
        return parent::render($request, $exception);
    }

    /**
     *
     * @param $request
     * @param ValidationException $exception
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function renderValidationException($request, ValidationException $exception)
    {
        return response([
           "errors" => $exception->errors()
        ],422);
    }

    /**
     * @param $request
     * @param Throwable $exception
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function renderOtherExceptions($request, Throwable $exception)
    {
        $exception=$this->prepareException($exception);
        $code=method_exists($exception,'getStatusCode') ? $exception->getStatusCode() : 500;
        $message='خطایی در سرور رخ داده است';
        if(!($code==500 || empty($exception->getMessage()))){
            $message=$exception->getMessage();
        }
        return response([
            'message' => $message
        ],$code);
    }

    private function renderAuthenticationException($request, Throwable $exception)
    {
        return response([
            'message' => 'شما به این api دسرسی ندارید'
        ],401);
    }
}
