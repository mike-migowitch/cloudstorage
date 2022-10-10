<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class SuccessJsonResponse
{
    public function __construct() {
        return new JsonResponse(['status' => 'success'], 200);
    }
}
