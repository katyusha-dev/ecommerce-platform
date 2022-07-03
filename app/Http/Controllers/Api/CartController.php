<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use Features\Purchasing\Enums\PaymentProvidersEnum;
use App\Http\Controllers\Actions\Purchasing\CheckoutAction;
use App\Http\Controllers\Actions\Purchasing\AddItemToCartAction;
use App\Http\Controllers\Actions\Purchasing\InitializeCartAction;

class CartController extends ApiController {
    /**
     * Get or create session.
     */
    public function initializeCart(): JsonResponse {
        return $this->json(InitializeCartAction::run($this->shop));
    }

    /**
     * Initialize Vipps checkout.
     */
    public function checkoutWithVipps(): JsonResponse {
        return $this->json(CheckoutAction::run($this->shop, PaymentProvidersEnum::VIPPS));
    }

    /**
     * Initialize Stripe checkout.
     */
    public function checkoutWithStripe(): JsonResponse {
        return $this->json(CheckoutAction::run($this->shop, PaymentProvidersEnum::STRIPE));
    }

    /**
     * Add a product to cart.
     *
     * @warn
     */
    public function addProductToCart(string $productId, int $qty, string $variationId) {
        return $this->json(AddItemToCartAction::run($this->shop, $productId, $qty, $variationId));
    }
}
