<?php

namespace App\Http\Controllers\Sketches\Traits;

use Features\Purchasing\Order;

trait UsesOrder
{
    protected ?Order $order;

    public function __construct()
    {
        parent::__construct();

        if ($id = $this->request->get('order_id')) {
            $this->order = Order::getItem($id);
        }
    }
}
