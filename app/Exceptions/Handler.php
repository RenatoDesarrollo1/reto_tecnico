<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
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
        $this->reportable(function (Throwable $e) {});


        $this->renderable(function (AuthenticationException  $e, $request) {
            DB::rollBack();
            return $this->responseError(null, 'El usuario no está autenticado', JsonResponse::HTTP_UNAUTHORIZED);
        });

        $this->renderable(function (UnauthorizedException $e, $request) {
            DB::rollBack();
            return $this->responseError(null, 'El usuario no tiene permisos', $e->getStatusCode());
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            $prev = $e->getPrevious();
            $modelClass = $prev->getModel();
            if (class_exists($modelClass) && is_subclass_of($modelClass, Model::class)) {
                $modelInstance = new $modelClass();
                $message = $modelInstance->getMessage('notfound');
            }
            DB::rollBack();
            return $this->responseError(null, $message, JsonResponse::HTTP_NOT_FOUND);
        });

        $this->renderable(function (ValidationException $e, $request) {
            $message = $e->getMessage();
            $errors = $e->errors();
            DB::rollBack();
            return $this->responseError($errors, $message, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        });

        $this->renderable(function (Exception $e, $request) {
            DB::rollBack();
            return $this->responseError(null, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
