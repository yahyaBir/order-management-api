<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Order;
use App\Models\Product;

class OrderDetailService
{
    public function getOrderDetail($orderId)
    {
        $order = Order::with(['items.product.author', 'items.product.category'])->find($orderId);

        if (!$order) {
            return null;
        }

        return [
            'orderId' => $order->id,

            'items' => $order->items->map(function($item) {
                return [
                    'productId' => $item->product_id,
                    'productName' => $item->product->title,
                    'authorname' => $item->product->author->name,
                    'authororigin' => $item->product->author->author_origin,
                    'categoryTitle' => $item->product->category->title,
                    'price' => $item->product->list_price,
                    'quantity' => $item->quantity,
                ];
            }),
            'orderAmount' => $order->order_amount,
            'shippingCost' => $order->shipping_cost,
            'discountedAmount' => $order->discounted_amount,
            'appliedCampaign' => $order->applied_campaign,
            'totalAmount' => $order->total_amount,
            'status' => $order->status,
        ];
    }

}
