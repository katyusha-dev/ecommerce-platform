<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Authentication;

use DateTime;
use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\Authentication\InvalidArgumentException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Authorization\ResponseGetToken;

/**
 * Class TokenMemoryCacheStorage.
 */
class TokenMemoryCacheStorage implements TokenStorageInterface
{
    protected ResponseGetToken $token;

    public function get(): ResponseGetToken
    {
        if (! $this->has()) {
            throw new InvalidArgumentException('Missing Token');
        }

        return $this->token;
    }

    public function set(ResponseGetToken $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function has(): bool
    {
        if (! ($this->token instanceof ResponseGetToken)) {
            return false;
        }

        if ($this->token->getExpiresOn()->getTimestamp() < (new DateTime())->getTimestamp()) {
            $this->delete();

            return false;
        }

        return true;
    }

    public function delete(): self
    {
        $this->token = null;

        return $this;
    }

    public function clear(): self
    {
        $this->delete();

        return $this;
    }
}
