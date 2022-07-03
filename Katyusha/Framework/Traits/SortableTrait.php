<?php

namespace Katyusha\Framework\Traits;

use Spatie\EloquentSortable\SortableTrait as SSortableTrait;

trait SortableTrait
{
    use SSortableTrait;

    public function scopeStatus($query)
    {
        return $query->orderBy('sort_order', 'DESC');
    }
}
