<?php

namespace Features\Catalog;

use Features\Shop\Shop;

class ProductSearch
{
    public function __construct(protected Shop $shop)
    {
    }

    public static function make(Shop $shop): self
    {
        return new self($shop);
    }

    public function indexQuery()
    {
        return $this->shop->getProductIndex()->query()->getResults();
    }
}
