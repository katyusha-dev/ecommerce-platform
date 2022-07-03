<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Features\Catalog\Product;
use Features\Customer\Customer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Actions\Customer\AuthenticateAction;
use App\Http\Controllers\Actions\Customer\CustomerUpdateAction;
use App\Http\Controllers\Actions\Customer\InitializeSessionAction;

class CustomerController extends ApiController {
    /**
     * Saves the customer.
     */
    public function save(Request $request): bool {
        try {
            return CustomerUpdateAction::run($request->all());
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * List of favorite products.
     */
    public function favorites(): JsonResponse {
        return $this->json(Customer::loadFromRequest()?->favorites->toArray());
    }

    /**
     * Add a product to favorites.
     */
    public function addToFavorites(Request $request): void {
        Customer::loadFromRequest()?->favorites()->attach($request->get('id'));
    }

    /**
     * Removes a product from favorites.
     */
    public function removeFromFavorites(Request $request): void {
        Customer::loadFromRequest()?->favorites()->detach($request->get('id'));
    }

    /**
     * Get or create session.
     */
    public function initializeSession(): JsonResponse {
        return $this->json(InitializeSessionAction::run()->toArray());
    }

    /**
     * Authenticates a user or creates a new account.
     */
    public function authenticate(Request $request): JsonResponse {
        return $this->json(['authenticated' => AuthenticateAction::run($request->get('mobile'), $request->get('code'))]);
    }
}
