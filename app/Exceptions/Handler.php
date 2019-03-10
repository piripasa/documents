<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\Debug\Exception\FlattenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\QueryException;
use App\Exceptions\AuthException;
use Firebase\JWT\ExpiredException;
use Prettus\Validator\Exceptions\ValidatorException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        //return parent::render($request, $e);

        $exceptionClass = (new \ReflectionClass($e))->getShortName();
        $message = "Something went wrong on server";
        $debugMode = env('APP_DEBUG', config('app.debug', false));

        switch($exceptionClass){
            case 'HttpResponseException':
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                break;

            case 'MethodNotAllowedHttpException':
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = "Route has been used with wrong method";
                break;
            case 'ModelNotFoundException':
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = $debugMode ? $e->getMessage() : "No result found";
                break;
            case 'NotFoundHttpException':
                $status = Response::HTTP_NOT_FOUND;
                $message = "Requested route has not found";
                break;

            case 'AuthorizationException':
                $status = Response::HTTP_FORBIDDEN;
                $message = $e->getMessage() ?? "Wrong or invalid paramter provided";
                break;

            case 'ValidationException':
                $status = Response::HTTP_BAD_REQUEST;
                $message = "Wrong or invalid paramter provided";
                break;

            case 'InvalidArgumentException':
            case 'InvalidFileException':
            case 'InvalidException':
                $status = Response::HTTP_BAD_REQUEST;
                $message = $e->getMessage();
                break;

            case 'QueryException':
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = $debugMode ? $e->getMessage() : $message;
                break;

            case 'AuthException':
                $status = Response::HTTP_UNAUTHORIZED;
                $message = $e->getMessage();
                break;

            case 'ExpiredException':
                $status = Response::HTTP_UNAUTHORIZED;
                $message = $e->getMessage();
                break;

            case 'BadRequest400Exception':
                $status = Response::HTTP_BAD_REQUEST;
                $message = "Invalid search input provided";
                break;

            case 'ValidatorException':
                $status = Response::HTTP_BAD_REQUEST;
                $message = array_values(array_map(function($val){
                        return app('translator')->trans($val[0]);
                    }, $e->getMessageBag()->toArray())
                );
                break;

            default:
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = $debugMode ? $e->getMessage() : $message;
            break;
        }

        return response()->json([
            'error' => [
                'status' => $status,
                'type' => $exceptionClass,
                'messages' => (array)$message
            ]],
            $status
        );
    }
}
