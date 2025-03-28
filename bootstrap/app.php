<?php

use App\Http\ResponseCode;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Iqbalatma\LaravelUtils\APIResponse;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->context(fn() => [
            "user_agent" => request()->userAgent(),
            "ip" => request()->ip(),
            "body" => request()->all(),
            "url" => request()->url(),
            "method" => request()->method(),
        ]);

        $exceptions->dontReport([
            \Iqbalatma\LaravelUtils\Exceptions\DumpAPIException::class,
            \Illuminate\Validation\ValidationException::class,
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
        ]);

        $exceptions->render(function (\Iqbalatma\LaravelJwtAuthentication\Exceptions\JWTUnauthenticatedUserException $e) {
            return new APIResponse(
                message: $e->getMessage(),
                responseCode: ResponseCode::ERR_UNAUTHENTICATED(),
                exception: $e
            );
        });


        $exceptions->render(function (Error|Exception|RuntimeException|Throwable $e) {
            return response()->json([
                "rc" => ResponseCode::ERR_INTERNAL_SERVER_ERROR()->name,
                "message" => isProduction() ? "Something went wrong !" : $e->getMessage(),
                "timestamp" => Carbon::now(),
                "payload" => null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })->create();
