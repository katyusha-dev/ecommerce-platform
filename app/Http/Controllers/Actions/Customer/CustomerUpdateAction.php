<?php

namespace App\Http\Controllers\Actions\Customer;

use Throwable;
use Features\Customer\Customer;
use Katyusha\Framework\Support\Action;

/**
 * @method static string run(array|object $data)
 */
class CustomerUpdateAction extends Action {
    /**
     * @throws Throwable
     */
    public function handle(array|object $data): bool {
        if (!$customer = Customer::loadFromRequest()) {
            return false;
        }

        return $customer->fill($data)->saveOrFail();
    }
}
