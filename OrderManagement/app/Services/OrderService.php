<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderService
{
    public function createOrder($orderData)
    {
        $validator = Validator::make($orderData, [
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->save();

        $totalAmount = 0;
        $discountedAmount = 0;
        $discountAmount = 0;

        foreach ($orderData['order_items'] as $order_item) {
            $product = Product::find($order_item['product_id']);

            if (!$product) {
                return ['status' => 'error', 'message' => 'Product not found'];
            }

            if ($product->stock_quantity >= $order_item['quantity']) {

                $items = new OrderItem();
                $items->order_id = $order->id;
                $items->product_id = $order_item['product_id'];
                $items->quantity = $order_item['quantity'];
                $items->price = $product->list_price;
                $items->save();

                $totalAmount += $items->quantity * $items->price;

                $product->stock_quantity -= $order_item['quantity'];
                $product->save();

            } else {
                return ['status' => 'error', 'message' => 'Insufficient stock'];
            }
        }

        $shipping_cost = $totalAmount > 50 ? 0 : 10;
        $totalAmount += $shipping_cost;

        $order->shipping_cost = $shipping_cost;
        $order->total_amount = $totalAmount;
        $order->save();

        return ['status' => 'success', 'order' => $order];
    }
}

