<?php

namespace Features\DataMapping\ShopAndWoo\Entities;

use function array_keys;
use function array_values;
use Features\DataMapping\Exceptions\DataMappingException;
use Features\DataMapping\ShopAndWoo\ShopAndWooEntity;
use function get_post_thumbnail_id;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use function is_array;
use Katyusha\Shop\Database\Models\ProductModel;
use Katyusha\Utils\_;
use WC_Product;
use WC_Product_Simple;
use WC_Product_Variable;
use Wordpress\Cdn\Cdn;
use Wordpress\Woocommerce\Product;

class ProductEntity extends ShopAndWooEntity
{
    public array $wooData = [];
    protected array $shopData = [];
    protected bool $forceIntVals = true;
    protected ProductModel $shopModel;

    protected $mapping = [
        'id', 'price', 'name', 'slug', 'description',  'sku', 'status',
    ];

    public function __construct(protected WC_Product|WC_Product_Variable|WC_Product_Simple $wooModel)
    {
        $this->wooData = $wooModel->get_data();

        if ($match = ProductModel::where('id', $this->wooModel->get_id())->first()) {
            $this->shopModel = $match;
            $this->mapShopFields()->mapDualFields();
            $this->fillShopModel();
        } else {
            $this->shopModel = new ProductModel();
            $this->shopModel->setAttribute('id', $this->wooModel->get_id());

            $this->shopModel->save();
        }

        $this->shopData = $this->shopModel->toArray();
    }

    public function fillShopModel(): self
    {
        $model = $this->shopModel;
        foreach ($this->values as $key => $value) {
            $model->setAttribute($key, $value);
        }

        $this->shopModel = $model;

        return $this;
    }

    public function updateOrCreateShopModel(): ProductModel
    {
        try {
            $this->shopModel->fill($this->shopData)->save();
        } catch (QueryException $exception) {
            DataMappingException::help($exception->getMessage(), ['data' => $this->data()]);
        }

        return ProductModel::where('id', $this->wooModel->get_id())->first();
    }

    public function getShopModel(): ProductModel
    {
        return $this->shopModel;
    }

    public function isSimple(): bool
    {
        return $this->wooModel instanceof WC_Product_Variable;
    }

    public function isVariable(): bool
    {
        return $this->wooModel instanceof WC_Product_Simple;
    }

    protected function data(): array
    {
        return [
            'wooProduct' => $this->wooData,
            'shopProduct' => $this->shopData,
            'mapping' => $this->mapping,
        ];
    }

    protected function mapShopFields(): self
    {
        $this->set('product_type', $this->isSimple() ? 'simple' : 'variable')
            ->set('sale_price', _::toInt($this->wooModel->get_sale_price()))
            ->set('quantity', $this->wooModel->get_stock_quantity() ?? 0)
            ->set('is_taxable', $this->wooModel->is_taxable() ? 1 : 0)
            ->set('in_stock', $this->wooModel->is_in_stock() ? 1 : 0)
            ->set('image', $this->parseImage())
            ->set('gallery', $this->parseGallery());

        return $this;
    }

    protected function mapDualFields(): self
    {
        foreach ($this->mapping as $item) {
            $shopKey = is_array($item) ? array_keys($item)[0] : $item;
            $wooKey = is_array($item) ? array_values($item)[0] : $item;

            if (! isset($this->wooData[$wooKey])) {
                DataMappingException::help("WooCommerce missing key: ${wooKey}", ['data' => $this->data(), 'item' => $item, 'shopKey' => $shopKey, 'wooKey' => $wooKey]);
            }

            $this->set($shopKey, $this->wooData[$wooKey]);
        }

        return $this;
    }

    protected function parseImage(): array
    {
        $mediaId = get_post_thumbnail_id($this->wooModel->get_id());

        if (! $mediaId) {
            return [];
        }

        $meta = wp_get_attachment_metadata($mediaId);

        if (! $meta) {
            return [];
        }

        $url = Cdn::getWpMediaUrl($meta['file']);

        return ['id' => Str::random(), 'original' => $url, 'thumbnail' => $url];
    }

    protected function parseGallery(): array
    {
        $images = [];
        foreach (Product::getAllImagesURLs($this->wooModel->get_id()) as $url) {
            $images[] = ['id' => Str::random(), 'original' => $url, 'thumbnail' => $url];
        }

        return $images;
    }
}
