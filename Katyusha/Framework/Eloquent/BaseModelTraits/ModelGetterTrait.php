<?php

namespace Katyusha\Framework\Eloquent\BaseModelTraits;

use Carbon\Carbon;
use Katyusha\Framework\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * @mixin Model
 *
 * @property string parsedCreatedAt
 * @property string relativeCreatedAt
 */
trait ModelGetterTrait
{
    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getParsedCreatedAtAttribute(): string
    {
        return Carbon::createFromTimeString($this->getAttribute('created_at'))->format('D d/m H:i:s');
    }

    public function getRelativeCreatedAtAttribute(): string
    {
        return Carbon::createFromTimeString($this->getAttribute('created_at'))->shortRelativeDiffForHumans();
    }

    public static function getByNamespace(string $namespace): ?static
    {
        return self::query()->where('namespace', $namespace)->first();
    }

    final public static function getItem(?string $id = null): ?static
    {
        return $id && Uuid::isValid($id) ? static::getByField('id', $id) : null;
    }

    public static function getByField(string $field, mixed $value): ?static
    {
        $query = static::query();

        if (method_exists($query, 'withTrashed')) {
            return $query->withTrashed()->where($field, $value)->first();
        }

        return $query->where($field, $value)->get()->first();
    }
}
