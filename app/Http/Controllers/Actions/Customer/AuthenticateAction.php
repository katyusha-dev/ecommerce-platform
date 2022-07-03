<?php

namespace App\Http\Controllers\Actions\Customer;

use Features\Customer\Customer;
use Features\Customer\CustomerSession;
use Katyusha\Framework\Support\Action;

/**
 * @method static string run(int $mobileNumber, string $password)
 */
class AuthenticateAction extends Action {
    public function handle(int $mobileNumber, int $password): bool {
        $customer = Customer::getCustomerByCredentials($mobileNumber, $password);

        if (!$customer) {
            return false;
        }

        $session = CustomerSession::loadFromRequest();

        if (!$session) {
            $session = CustomerSession::newSession();
        }

        $session->assignCustomerId($customer->id);

        return true;
    }
}
