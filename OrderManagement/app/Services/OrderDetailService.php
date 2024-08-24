<?php

namespace App\Services;

use App\Models\Order;
use App\Http\Resources\OrderDetailResource;

class OrderDetailService
{
    public function getOrderDetail($orderId)
    {
        $order = Order::with(['items.product.author', 'items.product.category'])->find($orderId);

        if (!$order) {
            return null;
        }

        return new OrderDetailResource($order);
    }
}
