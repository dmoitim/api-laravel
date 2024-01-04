<?php

namespace App\Traits;

use Illuminate\Support\MessageBag;
use Illuminate\Http\Resources\Json\JsonResource;

trait HttpResponses
{
    public function success(string $message, int $status, array|JsonResource $data = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data
        ]);
    }

    public function error(string $message, string|int $status, array|MessageBag $errors = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'errors' => $errors
        ]);
    }
}
