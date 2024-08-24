<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'orderId' => $this->id,
            'items' => $this->items->map(function ($item) {
                return [
                    'productId' => $item->product_id,
                    'productName' => $item->product->title,
                    'authorName' => $item->product->author->name,
                    'authorOrigin' => $item->product->author->author_origin,
                    'categoryTitle' => $item->product->category->title,
                    'price' => $item->product->list_price,
                    'quantity' => $item->quantity,
                ];
            }),
            'orderAmount' => $this->order_amount,
            'shippingCost' => $this->shipping_cost,
            'discountedAmount' => $this->discounted_amount,
            'appliedCampaign' => $this->applied_campaign,
            'totalAmount' => $this->total_amount,
            'status' => $this->status,
        ];
    }
}
