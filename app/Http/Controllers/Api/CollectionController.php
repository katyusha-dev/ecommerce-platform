<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class CollectionController extends ApiController {
    public function products(): JsonResponse {
        return $this->json($this->shop->products);
    }

    public function topSellers(): JsonResponse {
        return $this->json($this->shop->products()->where('featured', true)->get());
    }

    public function featuredProducts(): JsonResponse {
        return $this->json($this->shop->products()->where('featured', true)->get());
    }

    public function saleProducts(): JsonResponse {
        return $this->json($this->shop->products()->where('sale_price', true)->get());
    }

    public function newProducts(): JsonResponse {
        return $this->json($this->shop->products()->orderBy('created_at', 'DESC')->limit(request()->get('limit'))->get());
    }

    public function categories(): JsonResponse {
        return $this->jsonArray($this->shop->categories()->whereNull('parent_id')->with(['children', 'products'])->get());
    }

    public function featuredCategories(): JsonResponse {
        return $this->json($this->shop->categories()->whereNull('parent_id')->with(['children', 'products'])->get());
    }

    public function catalogCollections(): JsonResponse {
        return $this->jsonArray($this->shop->collections);
    }
}
