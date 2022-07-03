<?php

namespace Katyusha\Framework\Eloquent\BaseModelTraits;

use App\Framework\Utilities\Underscore;
use Katyusha\Framework\Eloquent\Model;
use stdClass;

/**
 * @mixin Model
 */
trait ModelAttributeTrait
{
    public function getUpdatedAtColumn()
    {
        return null;
    }

    public function getAttributesAsArray(...$attrs): array
    {
        $res = [];
        foreach ($attrs as $attr) {
            $res[$attr] = $this->{$attr};
        }

        return $res;
    }

    public function set(string $key, mixed $value): static
    {
        $this->setAttribute($key, $value);

        return $this;
    }

    public function getAttrAsBool(string $key): bool
    {
        return Underscore::toBool($this->getAttr($key));
    }

    public function getAttrAsInt(string $key): int
    {
        return Underscore::toInt($this->getAttr($key));
    }

    public function getAttrAsFloat(string $key): int
    {
        return Underscore::toFloat($this->getAttr($key));
    }

    public function getAttrJsonDecoded(string $attr): stdClass | array | null
    {
        $attr = $this->getAttr($attr);

        return $attr ? json_decode($attr) : null;
    }

    public function getAttr(string $key): mixed
    {
        return $this->getAttribute($key);
    }

    public function unsetAttribute(string $attr): static
    {
        unset($this->{$attr});
        $this->{$attr} = null;

        return $this;
    }

    public function unsetAttributes(...$attrs): static
    {
        foreach ($attrs as $attr) {
            $this->unsetAttribute($attr);
        }

        return $this;
    }
}
