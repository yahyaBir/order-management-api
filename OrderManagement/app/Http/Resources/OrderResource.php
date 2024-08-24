<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'items' => $this->items->map(function($item) {
                return [
                    'productId' => $item->product_id,
                    'quantity' => $item->quantity,
                ];
            }),
            'order_amount' => $this->order_amount,
            'discounted_amount' => $this->discounted_amount,
            'shipping_cost' => $this->shipping_cost,
            'total_amount' => $this->total_amount,
            'applied_campaign' => $this->applied_campaign,
            'status' => $this->status,
        ];
    }
}
