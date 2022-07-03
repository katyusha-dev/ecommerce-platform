<?php

namespace Features\Shop\Traits;

use Illuminate\Database\Eloquent\Collection;

trait ShopDataAccessors
{
    public function getMainCategories(): Collection {
        return $this->categories()->whereNull('parent_id')->get();
    }

}