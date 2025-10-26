<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthenticationException::class,
        ValidationException::class,
        NotFoundHttpException::class,
        ModelNotFoundException::class,
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
        'password_new',
        'token',
        'api_key',
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

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception): Response
    {
        // Handle JSON requests with optimized response structure
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->renderJsonException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render JSON exception response with proper status codes and structure.
     */
    protected function renderJsonException(Request $request, Throwable $exception): JsonResponse
    {
        $statusCode = $this->getStatusCode($exception);
        $message = $this->getExceptionMessage($exception);
        
        $response = [
            'success' => false,
            'message' => $message,
            'status_code' => $statusCode,
        ];

        // Add validation errors for ValidationException
        if ($exception instanceof ValidationException) {
            $response['errors'] = $exception->errors();
        }

        // Add debug information only in debug mode
        if (config('app.debug')) {
            $response['debug'] = [
                'exception' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => collect($exception->getTrace())->take(5)->toArray(), // Limit trace for performance
            ];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Get the status code from the exception.
     */
    protected function getStatusCode(Throwable $exception): int
    {
        if ($exception instanceof HttpException) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof ValidationException) {
            return 422;
        }

        if ($exception instanceof AuthenticationException) {
            return 401;
        }

        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return 404;
        }

        return 500;
    }

    /**
     * Get user-friendly message from exception.
     */
    protected function getExceptionMessage(Throwable $exception): string
    {
        // Don't expose internal errors in production
        if (!config('app.debug')) {
            return match (true) {
                $exception instanceof ValidationException => 'The given data was invalid.',
                $exception instanceof AuthenticationException => 'Unauthenticated.',
                $exception instanceof ModelNotFoundException,
                $exception instanceof NotFoundHttpException => 'Resource not found.',
                $exception instanceof HttpException => $exception->getMessage() ?: 'An error occurred.',
                default => 'Internal server error.',
            };
        }

        return $exception->getMessage() ?: 'An unexpected error occurred.';
    }
}
