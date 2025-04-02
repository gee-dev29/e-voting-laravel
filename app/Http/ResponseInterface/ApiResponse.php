<?php

namespace App\Http\ResponseInterface;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
  public static function success(string $message, int $statusCode = StatusCode::OK): JsonResponse
  {
    return new JsonResponse(['message' => $message], $statusCode);
  }

  public static function error(string $message, string $error, int $statusCode = StatusCode::BAD_REQUEST): JsonResponse
  {
    return new JsonResponse(['message' => $message, 'error' => $error], $statusCode);
  }

  public static function data($data, int $statusCode = StatusCode::OK): JsonResponse
  {
    return new JsonResponse($data, $statusCode);
  }

  public static function noContent(int $statusCode = StatusCode::NO_CONTENT): JsonResponse
  {
    return new JsonResponse(null, $statusCode);
  }
}
