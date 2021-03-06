<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        JWTException::class,
        TokenBlacklistedException::class,
        TokenInvalidException::class,
        TokenExpiredException::class,
        ValidationException::class,
        CustomValidationException::class,
        ModelNotFoundException::class,
        NotFoundHttpException::class,
        RouteNotFoundException::class,
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
        $exceptionName = (new \ReflectionClass($exception))->getShortName();

        if ($request->is("api/*")) {
            $this->tokenExceptionList($exception);
            $this->validationExceptionList($exception);
            $this->eloquentExceptionList($exception);
            $this->routeExceptionList($exception);

            // Caso nenhuma exce????o seja executada acima.
            return responseError(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST,
                "Unexpected exception [${exceptionName}]",
            );
        }

        return parent::render($request, $exception);
    }

    private function tokenExceptionList(Throwable $exception): void
    {
        $exceptionName = (new \ReflectionClass($exception))->getShortName();

        // Token n??o pode ser utilizado
        if ($exceptionName === 'TokenBlacklistedException') {
            responseError(
                trans('auth_lang.token_cant_used'),
                Response::HTTP_BAD_REQUEST,
                $exceptionName,
            );
            exit();
        }

        // Token inv??lido
        if ($exceptionName === 'TokenInvalidException') {
            responseError(
                trans('auth_lang.token_is_invalid'),
                Response::HTTP_BAD_REQUEST,
                $exceptionName,
            );
            exit();
        }

        // Token expirado
        if ($exceptionName === 'TokenExpiredException') {
            responseError(
                trans('auth_lang.token_is_expired'),
                Response::HTTP_BAD_REQUEST,
                $exceptionName,
            );
            exit();
        }

        // Token n??o informado
        if ($exceptionName === 'JWTException') {
            responseError(
                trans('auth_lang.token_not_provided'),
                Response::HTTP_BAD_REQUEST,
                $exceptionName,
            );
            exit();
        }
    }

    private function validationExceptionList(Throwable $exception): void
    {
        $exceptionName = (new \ReflectionClass($exception))->getShortName();

        // Valida????o dos dados
        if ($exceptionName === 'ValidationException') {
            responseError(
                $exception->errors(),
                $exception->status,
                $exceptionName,
            );
            exit();
        }

        // Valida????o dos dados (Customizada)
        if ($exceptionName === 'CustomValidationException') {
            responseError(
                $exception->errors(),
                $exception->status(),
                $exceptionName,
            );
            exit();
        }        
    }

    private function eloquentExceptionList(Throwable $exception): void
    {
        $exceptionName = (new \ReflectionClass($exception))->getShortName();

        // Model n??o encontrado
        if ($exceptionName === 'ModelNotFoundException') {
            responseError(
                $exception->errors(),
                Response::HTTP_BAD_REQUEST,
                $exceptionName,
            );
            exit();
        }

        // Erro de query
        if ($exceptionName === 'QueryException') {
            responseError(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST,
                $exceptionName,
            );
            exit();
        }
    }

    private function routeExceptionList(Throwable $exception): void
    {
        $exceptionName = (new \ReflectionClass($exception))->getShortName();

        // Rota n??o encontrada
        if ($exceptionName === 'NotFoundHttpException') {
            responseError(
                trans('message_lang.not_found_route_http'),
                Response::HTTP_NOT_FOUND,
                $exceptionName,
            );
            exit();
        }

        // Rota n??o encontrada
        if ($exceptionName === 'RouteNotFoundException') {
            responseError(
                trans('message_lang.route_not_found_or_token_invalid'),
                Response::HTTP_NOT_FOUND,
                $exceptionName,
            );
            exit();
        }
    }
}
