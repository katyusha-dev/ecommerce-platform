<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class SearchController extends ApiController {
    public function search(Request $request): JsonResponse {
        $q = $request->get(trim('q'));

        return $this->json($this->shop->products()->where('name', 'ILIKE', "%{$q}%")->get());
    }
}
