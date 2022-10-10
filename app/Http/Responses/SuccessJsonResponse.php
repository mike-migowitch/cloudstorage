<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class SuccessJsonResponse extends JsonResponse
{
    public function __construct() {
        parent::__construct(['status' => 'success'], 200, [], 0,false);
    }
}
