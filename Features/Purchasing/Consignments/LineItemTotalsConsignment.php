<?php

namespace Features\Purchasing\Consignments;

use Features\Purchasing\LineItem;

class LineItemTotalsConsignment
{
    public function __construct(public int $total, public int $totalWithoutTax, public int $tax)
    {
    }

    public static function createFromLineItem(LineItem $lineItem): self
    {
        $itemPrice = $lineItem->individual_item_price->getAmount();
        $total = $itemPrice * $lineItem->qty;
        $tax = $lineItem->taxRate->getTaxAmountOfValue($total);
        $totalWoTax = $total - $tax;

        return new self($total, $totalWoTax, $tax);
    }
}
