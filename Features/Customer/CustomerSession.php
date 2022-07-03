<?php

namespace Features\Customer;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Features\Customer\Models\CustomerSessionModel;

class CustomerSession extends CustomerSessionModel {
    protected static string $cookieKey = 's';

    public static function loadFromRequest(): ?static {
        if ($sessionKey = static::loadSessionKeyFromRequest()) {
            return static::getFromKey($sessionKey);
        }

        return null;
    }

    public static function loadSessionKeyFromRequest(): ?string {
        return Cookie::get(static::$cookieKey);
    }

    public static function getFromKey(string $key): ?static {
        return self::where('key', $key)->first();
    }

    public function assignCustomerId(string $customerId): static {
        return $this->setCustomerId($customerId)->saveAndReturnModel();
    }

    public static function newSession(): static {
        $session = static::make()->setKey(Str::random(128))->saveAndReturnModel();
        Cookie::queue(static::$cookieKey, $session->getKey(), 1000000);

        return $session;
    }
}
