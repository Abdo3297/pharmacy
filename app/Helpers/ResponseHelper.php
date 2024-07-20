<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseHelper
{
    public static function finalResponse(string $message, mixed $data, bool $success, int $status): JsonResponse|JsonResource
    {
        if ($data instanceof JsonResource) {
            return $data->additional([
                'message' => $message,
                'success' => $success,
                'status' => $status,
            ]);
        }

        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => $success,
            'status' => $status,
        ], $status);
    }
}
