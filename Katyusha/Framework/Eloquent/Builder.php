<?php

namespace Katyusha\Framework\Eloquent;

use App\Framework\Utilities\Time;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as LaravelBuilder;
use function is_bool;
use function str_replace;
use function vsprintf;

/**
 * Class EloquentBuilder.
 */
class Builder extends LaravelBuilder
{
    use BuilderMixins;

    public function whereShopId(string $shopId): static
    {
        return $this->where('shop_id', $shopId);
    }

    public function whereExternalId(int $id): static
    {
        return $this->where('external_id', $id);
    }

    public function toSql(): string
    {
        return vsprintf(str_replace('?', '%s', str_replace('?', "'?'", parent::toSql())), static::getBindings());
    }

    public function get($columns = ['*']): mixed
    {
        return parent::get($columns);
    }

    public function first($columns = ['*']): mixed
    {
        return parent::first($columns);
    }

    public function getModel()
    {
        return parent::getModel();
    }

    public function whenFalse(mixed $condition, callable $callback, callable | null $default = null): static
    {
        return $this->when(! $condition, $callback, $default);
    }

    public function whereBool(string $column, mixed $boolean): static
    {
        return ! is_bool($boolean) ? $this : $this->where($column, '=', $boolean);
    }

    public function whereCreatedAtBetween(Carbon $from, Carbon $to): static
    {
        return $this->whereTimeBetween('created_at', $from, $to);
    }

    public function ilike(string $column, string $term): static
    {
        return $this->where($column, 'ILIKE', $term);
    }

    public function whereTimeBetween(string $timeField, Carbon $from, Carbon $to): static
    {
        return $this->where($timeField, '>=', $from->format(Time::DB_TIMESTAMP_FORMAT))->where($timeField, '<=', $to->format(Time::DB_TIMESTAMP_FORMAT));
    }

    public function whereTrue(string $column): static
    {
        return $this->where($column, '=', 'true');
    }

    public function whereId(string $id): static
    {
        return $this->where('id', $id);
    }

    public function whereFalse(string $column): static
    {
        return $this->where($column, '=', 'false');
    }

    public function rawAggregate(string $aggregate, string $column, ?string $as = null): static
    {
        return $this->selectRaw($aggregate.'('.$this->getModel()->getTable().'.'.$column.') AS '.($as ? $as : $aggregate));
    }

    public function withRecordsCount(): static
    {
        return $this->rawAggregate('count', $this->getModel()->getKeyName(), 'total_records');
    }

    public function orderByTotalRecords(): static
    {
        return $this->orderBy('total_records', 'DESC');
    }

    public function selectRawFromTable(string $column, ?string $table = null): static
    {
        return $this->selectRaw(($table ? $table : $this->getModel()->getTable()).'.'.$column);
    }

    public function selectAndGroupByRaw(string $column, bool $alsoOrderBy = false, string $orderDirection = 'DESC'): static
    {
        $this->selectRaw($column)->groupByRaw($column);

        return $alsoOrderBy ? $this->orderBy($column, $orderDirection) : $this;
    }
}
