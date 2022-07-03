<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class MediaController extends ApiController
{
    public function banners(): JsonResponse
    {
        return $this->json($this->shop->banners);
    }
}
