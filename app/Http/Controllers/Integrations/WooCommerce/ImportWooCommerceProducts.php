<?php

namespace App\Http\Controllers\Integrations\WooCommerce;

use App\Api\Action;
use App\Applications\Shops\App\Shop;
use App\Clients\WooCommerce\ElasticIndexes\ProductIndex;
use Elastica\Bulk\ResponseSet;

/**
 * @method static mixed run(Shop $shop)
 */
class ImportWooCommerceProducts extends Action
{
    /**
     * Importer of products from WooCommerce.
     */
    public function handle(Shop $shop): ResponseSet
    {
        return $shop->wooCommerce->allProductsDocuments()->indexAll(new ProductIndex($shop));
    }
}
