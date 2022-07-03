<?php

namespace App\Http\Controllers\Integrations\WooCommerce;

use App\Api\Action;
use App\Applications\Shops\App\Shop;
use App\Clients\WooCommerce\ElasticIndexes\AttributeIndex;
use App\Clients\WooCommerce\ElasticIndexes\ProductCategoryIndex;
use App\Clients\WooCommerce\ElasticIndexes\ProductTagIndex;

/**
 * @method static mixed run(Shop $shop)
 */
class ImportWooCommerceCategoriesAndTags extends Action
{
    /**
     * This will run the importer to fetch categories AND tags from WooCommerce and import them into the system.
     */
    public function handle(Shop $shop): array
    {
        $catIndex = new ProductCategoryIndex($shop);
        $tagIndex = new ProductTagIndex($shop);
        $attrIndex = new AttributeIndex($shop);

        return [
            'attributes' => $shop->wooCommerce->allAttributesDocument()->indexAll($attrIndex),
            'categories' => $shop->wooCommerce->allCategoriesDocuments()->indexAll($catIndex),
            'tags' => $shop->wooCommerce->allTagsDocuments()->indexAll($tagIndex),
        ];
    }
}
