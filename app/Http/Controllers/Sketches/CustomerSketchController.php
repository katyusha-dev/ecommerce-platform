<?php

namespace App\Http\Controllers\Sketches;

use App\Http\Controllers\Actions\Customer\AuthenticateAction;
use App\Http\Controllers\Actions\Customer\InitializeSessionAction;
use App\Http\Controllers\SketchController;
use Illuminate\Http\JsonResponse;

/**
 * Methods related to customers of shops and such.
 *
 * @order 20
 */
class CustomerSketchController extends SketchController
{
    /**
     * Get or create session.
     */
    public function initializeSession(): JsonResponse
    {
        return $this->json(['key' => InitializeSessionAction::run($this->shop)]);
    }

    /**
     * Authenticates a user or creates a new account.
     */
    public function authenticate(int $mobileNumber, string $password): JsonResponse
    {
        return $this->json(['authenticated' => AuthenticateAction::run($mobileNumber, $password)]);
    }
}
