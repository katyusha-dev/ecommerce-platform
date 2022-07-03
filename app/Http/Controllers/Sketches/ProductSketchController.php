<?php

namespace App\Http\Controllers\Sketches;

use App\Http\Controllers\SketchController;
use App\Http\Controllers\Sketches\Traits\UsesProduct;

/**
 * Methods related to individual (or multiple) products.
 *
 * @order 20
 */
class ProductSketchController extends SketchController
{
    use  UsesProduct;
    protected bool $productOptions = true;

    /**
     * Gets the product data.
     */
    public function getData(): void
    {
        $this->dd($this->product->toArray());
    }

    /**
     * Gets the variations of a product.
     */
    public function getVariations(): void
    {
        $this->dd($this->product->variations->toArray());
    }
}
