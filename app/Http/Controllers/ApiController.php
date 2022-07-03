<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use Features\Shop\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use function json_decode;
use function json_encode;
use Throwable;

class ApiController extends Controller
{
    protected Shop $shop;

    /**
     * @throws ApiException
     */
    public function __construct()
    {
        try {
            $this->shop = Shop::getFromRequest();
        } catch (Throwable $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function cachedResponse(string $cacheKey, callable $fn): JsonResponse
    {
        $key = $this->shop->getId().'.'.$cacheKey;

        if (! $cache = Cache::get($key)) {
            return $this->json(json_decode($cache));
        }

        $res = $fn();
        Cache::put($key, json_encode($res));

        return $this->json($res);
    }
}
