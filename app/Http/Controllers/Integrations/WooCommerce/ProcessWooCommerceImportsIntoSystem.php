<?php

namespace App\Http\Controllers\Integrations\WooCommerce;

use App\Api\Action;
use App\Applications\Eloquent\Collections\Products\ProductAttributeCollection;
use App\Applications\Eloquent\Collections\Products\ProductAttributeValueCollection;
use App\Applications\Eloquent\Collections\Products\ProductCategoriesCollection;
use App\Applications\Eloquent\Collections\Products\ProductsCollection;
use App\Applications\Eloquent\Collections\Products\ProductVariationCollection;
use App\Applications\Shops\App\Shop;
use App\Clients\WooCommerce\ApiModels\Objects\ProductImage;
use App\Clients\WooCommerce\ApiModels\Variation;
use App\Clients\WooCommerce\ElasticIndexes\AttributeIndex;
use App\Clients\WooCommerce\ElasticIndexes\ProductCategoryIndex;
use App\Clients\WooCommerce\ElasticIndexes\ProductIndex;
use App\Framework\Math\StringMath;
use Elasticsearch\ElasticsearchCreate;
use Exception;
use Features\Products\Modules\ComplexVariations\ComplexVariationRelationship;
use Features\Products\Modules\ComplexVariations\Eloquent\ComplexVariationCollection;
use Features\Products\Modules\Photos\ProductPhoto;
use Features\Products\Modules\ProductAttribute\ProductAttribute;
use Features\Products\Modules\ProductAttribute\ProductAttributeValue;
use Features\Products\Modules\ProductCategory\ProductCategory;
use Features\Products\Modules\ProductVariation\ProductVariation;
use Features\Products\Product;
use Illuminate\Database\QueryException;
use stdClass;

/**
 * @method static mixed run(Shop $shop)
 */
class ProcessWooCommerceImportsIntoSystem extends Action
{
    protected ?Shop $shop = null;

    /**
     * Takes the products in the "queue" and imports them.
     *
     * @throws Exception
     */
    public function handle(Shop $shop): mixed
    {
        $this->shop = $shop;

        return [
            'categories' => $this->parseCategories(),
            'attributes' => $this->parseAttributes(),
            'attribute_values' => $this->parseAttributeValues(),
            'products' => $this->parseProducts(),
        ];
    }

    public function parseAttributeValues(): ProductAttributeValueCollection
    {
        $collection = new ProductAttributeValueCollection();
        $products = ElasticsearchCreate::search(new ProductIndex($this->shop))->search();
        foreach ($products as $product) {
            $product = (object) $product->getSource();
            /** @var \App\Clients\WooCommerce\ApiModels\Product $product */
            foreach ($product->attributes as $attributeSource) {
                $attribute = ProductAttribute::getByImported($this->shop->getId(), $attributeSource['id']);
                foreach ($attributeSource['options'] as $optionValue) {
                    $collection->add(
                        ProductAttributeValue::make()
                            ->setName($optionValue)
                            ->setImportedId(StringMath::stringToNumericRepresentation($optionValue))
                            ->setShopId($this->shop->getId())
                            ->setAttributeId($attribute->getId())
                            ->import(false, 'name', $optionValue)
                    );
                }
            }
        }

        return $collection;
    }

    protected function parseCategories(): ProductCategoriesCollection
    {
        $categories = ElasticsearchCreate::search(new ProductCategoryIndex($this->shop))->search();
        $collection = new ProductCategoriesCollection();

        foreach ($categories as $importCategory) {
            $importCategory = (object) $importCategory->getSource();
            /** @var Category $importCategory */
            $collection->add(
                ProductCategory::make()
                    ->setName($importCategory->name)
                    ->setNamespace($importCategory->slug)
                    ->setShopId($this->shop->getId())
                    ->setImportedId($importCategory->id)
                    ->setDescription($importCategory->description)
                    ->import()
            );
        }

        return $collection;
    }

    protected function parseAttributes(): ProductAttributeCollection
    {
        $attributes = ElasticsearchCreate::search(new AttributeIndex($this->shop))->search();
        $collection = new ProductAttributeCollection();

        foreach ($attributes as $importAttribute) {
            $importAttribute = (object) $importAttribute->getSource();
            /** @var Attribute $importAttribute */
            $collection->add(
                ProductAttribute::make()
                    ->setName($importAttribute->name)
                    ->setShopId($this->shop->getId())
                    ->setImportedId($importAttribute->id)
                    ->import()
            );
        }

        return $collection;
    }

    /**
     * @throws Exception
     */
    protected function parseProducts(): ProductsCollection
    {
        $collection = new ProductsCollection();
        $products = ElasticsearchCreate::getAllDocumenmts(new ProductIndex($this->shop));

        foreach ($products as $product) {
            $collection->add($this->parseProductDocument((object) $product->getSource()));
        }

        return $collection;
    }

    /**
     * @throws Exception
     */
    protected function parseProductDocument(stdClass $toParse): Product
    {
        $variations = $toParse->variations;
        $categories = $toParse->categories;

        /*
         * Main product itself.
         */
        /** @var \App\Clients\WooCommerce\ApiModels\Product $toParse */
        $product = Product::make()
            ->setImportedId($toParse->id)
            ->setShopId($this->shop->getId())
            ->setStockCount($toParse->stock_quantity)
            ->setName($toParse->name)
            ->setNamespace($toParse->slug)
            ->setImportedFrom('woocommerce')
            ->setActive($toParse->status === 'publish')
            ->setFeatured($toParse->featured)
            ->setSku($toParse->sku)
            ->setPrice($toParse->price)
            ->setDescription($toParse->description)
            ->setSalePrice($toParse->sale_price ?? 0)
            ->import();

        /*
         * Images
         */
        /** @var ProductImage $image */
        foreach ($toParse->images as $image) {
            $image = (object) $image;
            ProductPhoto::saveFromUrl($product->getId(), $image->src, $image->id);
        }

        /*
         * Categories
         */
        $categoryIds = [];
        foreach ($categories as $cat) {
            $id = $cat['id'];
            $category = ProductCategory::where('imported_id', $id)->where('shop_id', $this->shop->getId())->first();
            $categoryIds[] = $category->getId();
        }

        $product->categories()->sync($categoryIds);

        /**
         * Variations.
         */
        $variationCollection = new ProductVariationCollection();
        foreach ($variations as $variation) {
            /** @var Variation $variation */
            $variation = (object) $variation;
            $attributesAndValues = [];
            $name = $product->getName();
            foreach ($variation->attributes as $attr) {
                $attribute = ProductAttribute::whereShopId($this->shop->getId())->where('imported_id', $attr['id'])->first();
                $value = ProductAttributeValue::where('attribute_id', $attribute->getId())->where('shop_id', $this->shop->getId())->where('name', $attr['option'])->first();
                $attributesAndValues[$attribute->getId()] = $value->getId();
                $name .= ' | '.$attribute->getName().': '.$value->getName();
            }

            $variation = ProductVariation::make()
                ->setName($name)
                ->setProductId($product->getId())
                ->setShopId($this->shop->getId())
                ->setSalePrice((float) $variation->sale_price)
                ->setPrice($variation->price)
                ->setRegularPrice($variation->regular_price)
                ->setStockCount($variation->manage_stock ? $variation->stock_quantity : 99999999)
                ->setImportedId($variation->id)
                ->import(true);

            $complexVariations = new ComplexVariationCollection();
            foreach ($attributesAndValues as $attrId => $valueId) {
                $complex = null;

                try {
                    $complex = ComplexVariationRelationship::make()->setAttributeId($attrId)->setAttributeValueId($valueId)->setVariationId($variation->getId())->saveAndReturnModel();
                } catch (QueryException $exception) {
                }

                if (! $complex) {
                    continue;
                }

                $complexVariations->add($complex);
            }

            $variationCollection->add($variation);
        }

        return $product;
    }
}
