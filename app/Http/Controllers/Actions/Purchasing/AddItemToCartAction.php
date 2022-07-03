<?php

namespace App\Http\Controllers\Actions\Purchasing;

use App\Exceptions\CartException;
use Features\Catalog\Product;
use Features\Catalog\Stock\Stock;
use Features\Catalog\Variables\Variation;
use Features\Fees\TaxRate;
use Features\Purchasing\LineItem;
use Features\Shop\Shop;
use Katyusha\Framework\Support\Action;

/**
 * @method static LineItem run(Shop $shop, string $productId, int $qty, string $variationId)
 */
class AddItemToCartAction extends Action
{
    /**
     * @throws CartException
     */
    public function handle(Shop $shop, string $productId, int $qty, string $variationId): LineItem
    {
        $product = Product::getItem($productId);
        $variation = $variationId ? Variation::getItem($variationId) : null;
        $item = $variation ? $variation : $product;
        $cart = InitializeCartAction::run($shop);
        $stockQty = Stock::getItemStock($item);

        if ($qty > $stockQty) {
            $qty = $stockQty;
        }

        if ($item->shop_id !== $shop->id) {
            throw new CartException('Product does not belongs to shop');
        }

        $taxRate = TaxRate::getProductTaxRate($product);
        $existingRowQuery = LineItem::where('cart_id', $cart->id)->where('product_id', $productId);

        if ($variationId) {
            $existingRowQuery->where('variation_id', $variationId);
        }

        if ($lineItem = $existingRowQuery->first()) {
            $lineItem->set('qty', $qty);
        } else {
            $lineItem = LineItem::make()
                ->setShopId($shop->id)
                ->setProductId($product->id)
                ->setQty($qty)
                ->setCartId($cart->id)
                ->setTaxRateId($taxRate->id);
        }

        if ($variation) {
            $lineItem->setVariationId($variation->id);
        }

        return $lineItem->saveAndReturnModel();
    }
}
