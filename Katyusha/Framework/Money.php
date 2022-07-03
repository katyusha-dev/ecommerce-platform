<?php

namespace Katyusha\Framework;

use Katyusha\Framework\Eloquent\Contracts\CastsAttributes;
use Katyusha\Framework\Eloquent\Model;

/**
 * Implementation of $$$$$$ MONEY MAKES THE WORLD GO `ROUND.
 */
class Money implements CastsAttributes
{
    public function __construct(protected ?int $amount = 0)
    {
    }

    public function get(Model $model, string $key, $value, array $attributes): mixed
    {
        return new self($value);
    }

    public function set(Model $model, string $key, $value, array $attributes): mixed
    {
        /** @var self $value */
        return [$key => $value->getAmount()];
    }

    public static function createFromMajorValue(int $amount): self
    {
        return new self($amount);
    }

    public static function createFromMinorValue(float $amount): self
    {
        return new self($amount * 100);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getAmountMinor(): float
    {
        return $this->amount / 100;
    }
}
