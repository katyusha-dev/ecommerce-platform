<?php

namespace App\Http\Controllers\Sketches;

use App\Http\Controllers\Actions\Purchasing\AddItemToCartAction;
use App\Http\Controllers\Actions\Purchasing\CheckoutAction;
use App\Http\Controllers\Actions\Purchasing\InitializeCartAction;
use App\Http\Controllers\SketchController;
use App\Http\Controllers\Sketches\Traits\UsesProduct;
use Features\Purchasing\Enums\PaymentProvidersEnum;
use Illuminate\Http\JsonResponse;

/**
 * Methods related to cart and purchasing.
 *
 * @order 20
 */
class CartSketchController extends SketchController
{
    use UsesProduct;

    protected bool $productOptions = true;

    /**
     * Get or create session.
     */
    public function initializeCart(): JsonResponse
    {
        return $this->json(InitializeCartAction::run($this->shop));
    }

    /**
     * Initialize Vippps checkout.
     */
    public function checkoutWithVipps(): JsonResponse
    {
        return $this->json(CheckoutAction::run($this->shop, PaymentProvidersEnum::VIPPS));
    }

    /**
     * Initialize Stripe checkout.
     */
    public function checkoutWithStripe(): JsonResponse
    {
        return $this->json(CheckoutAction::run($this->shop, PaymentProvidersEnum::STRIPE));
    }

    /**
     * Add a product to cart.
     *
     * @warn
     */
    public function addProductToCart(string $productId, int $qty, string $variationId)
    {
        return $this->json(AddItemToCartAction::run($this->shop, $productId, $qty, $variationId));
    }
}
