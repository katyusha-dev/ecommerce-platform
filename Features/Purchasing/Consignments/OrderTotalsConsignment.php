<?php

namespace Features\Purchasing\Consignments;

use Features\Purchasing\LineItem;
use Features\Purchasing\Order;
use Katyusha\Framework\Eloquent\Collection;

class OrderTotalsConsignment
{
    public function __construct(public int $total, public int $totalWithoutTax, public int $tax)
    {
    }

    public static function createFromOrder(Order $order): self
    {
        $lineItemTotals = new Collection();
        $order->lineItems()->each(fn (LineItem $item) => $lineItemTotals->add(LineItemTotalsConsignment::createFromLineItem($item)));

        return new self($lineItemTotals->sum('total'), $lineItemTotals->sum('totalWithoutTax'), $lineItemTotals->sum('tax'));
    }
}
