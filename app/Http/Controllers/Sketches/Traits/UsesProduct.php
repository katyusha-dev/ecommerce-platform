<?php

namespace App\Http\Controllers\Sketches\Traits;

use Features\Catalog\Product;

trait UsesProduct
{
    protected ?Product $product;

    public function __construct()
    {
        parent::__construct();

        if ($id = $this->request->get('product_id')) {
            $this->product = Product::getItem($id);
        }
    }
}
