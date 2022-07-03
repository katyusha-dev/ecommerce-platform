<?php

namespace Features\Purchasing;

use Features\Purchasing\Consignments\OrderTotalsConsignment;
use Features\Purchasing\Models\OrderModel;
use Katyusha\Framework\Money;

/**
 * @property Money total
 * @property Money totalTax
 * @property Money totalWithoutTax
 */
class Order extends OrderModel
{
    public function getTotals(): OrderTotalsConsignment
    {
        return OrderTotalsConsignment::createFromOrder($this);
    }

    protected function getTotalAttribute(): Money
    {
        return Money::createFromMajorValue($this->getTotals()->total);
    }

    protected function getTotalTaxAttribute(): Money
    {
        return Money::createFromMajorValue($this->getTotals()->tax);
    }

    protected function getTotalWithoutTaxAttribute(): Money
    {
        return Money::createFromMajorValue($this->getTotals()->totalWithoutTax);
    }
}
