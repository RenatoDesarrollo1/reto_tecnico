<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * Generate success type response.
     *
     * Returns the success data and message if there is any error
     *
     * @param object|null $data
     * @param string $message
     * @param integer $status_code
     * @return JsonResponse
     */
    public function responseSuccess($data, $message = "La petición fue realizada con éxito", $status_code = JsonResponse::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'errors'  => null,
            'data'    => $data,
        ], $status_code);
    }

    /**
     * Generate Error response.
     *
     * Returns the errors data if there is any error
     *
     * @param object|null $errors
     * @return JsonResponse
     */
    public function responseError($errors, $message = 'Ha ocurrido un error', $status_code = JsonResponse::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
            'data'    => null,
        ], $status_code);
    }
}
