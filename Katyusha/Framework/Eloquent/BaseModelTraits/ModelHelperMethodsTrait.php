<?php

namespace Katyusha\Framework\Eloquent\BaseModelTraits;

use App\Framework\Utilities\Arr;
use Illuminate\Eloquent\SoftDeletes;
use Katyusha\Framework\Eloquent\Model;

/**
 * @mixin Model
 */
trait ModelHelperMethodsTrait
{
    public function getId(): ?string
    {
        return $this->id;
    }

    public static function usesSoftDelete(): bool
    {
        return in_array(SoftDeletes::class, class_uses(static::class));
    }

    public static function hasStaticMethod(string $method): bool
    {
        return method_exists(static::class, $method);
    }

    public function methodExists(string $method): bool
    {
        return method_exists($this, $method);
    }

    public function toFormObject(): object
    {
        return $this->toObject();
    }

    public function toObject(): object
    {
        return Arr::toObject($this->toArray());
    }

    public static function callStatic(string $method): mixed
    {
        if (static::hasStaticMethod($method)) {
            return static::$method();
        }

        return null;
    }

    public function callMethod(string $method): mixed
    {
        if ($this->methodExists($method)) {
            return $this->{$method}();
        }

        return null;
    }
}
