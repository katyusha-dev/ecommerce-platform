<?php

namespace App\Http\Controllers\Api;

use function dd;
use Features\Shop\Shop;
use Features\Catalog\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class EntityController extends ApiController {
    public function category(Shop $shop, string $category): JsonResponse {
//        dd($this->shop);
//        dd($this->shop->categories()->where('namespace', $category)->toSql());
//        $category = DB::select(DB::raw("select * from product_groupings.categories where namespace = '${category}'"))[0];
        return $this->json(Category::query()->where('namespace', $category)->whereShopId($this->shop->getId())->with('products')->firstOrFail()->toArray());
    }

    public function product(Shop $shop, string $product): JsonResponse {
        return $this->json($shop->products()->where('namespace', $product)->whereShopId($this->shop->getId())->with('categories')->firstOrFail()->toArray());
    }
}
