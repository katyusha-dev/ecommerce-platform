<?php

namespace App\Http\Controllers\Actions\Customer;

use Features\Customer\CustomerSession;
use Katyusha\Framework\Support\Action;

/**
 * @method static CustomerSession run(?string $sessionKey = null)
 */
class InitializeSessionAction extends Action {
    public function handle(?string $sessionKey = null): CustomerSession {
        if (!$sessionKey) {
            $sessionKey = CustomerSession::loadSessionKeyFromRequest();
        }

        if ($sessionKey && $session = CustomerSession::getFromKey($sessionKey)) {
            return $session;
        }

        return CustomerSession::newSession();
    }
}
