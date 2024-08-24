<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderService
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

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

        $orderAmount = 0;
        $orderItems = collect();

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

                $orderAmount += $items->quantity * $items->price;
                $orderItems->push($items);

                $product->stock_quantity -= $order_item['quantity'];
                $product->save();
            } else {
                return ['status' => 'error', 'message' => 'Insufficient stock'];
            }
        }
        try {
        $campaignResult = $this->campaignService->applyBestCampaign($orderItems, $orderAmount);
        $initialAmount = $orderAmount;
        $discountedAmount = $initialAmount - $campaignResult['discount'];
        $discountAmount = $campaignResult['discount'];
        $shippingCost = $discountedAmount > 50 ? 0 : 10;
        $totalAmount = $discountedAmount + $shippingCost;

        $order->order_amount = $orderAmount;
        $order->discounted_amount = $discountAmount;
        $order->shipping_cost = $shippingCost;
        $order->total_amount = $totalAmount;
        $order->applied_campaign = $campaignResult['appliedCampaign'];
        $order->save();
            return [
                'status' => 'success',
                'order' => $order,
            ];
        }catch (\Exception $e){
            return response()->json($e,500);
        }
    }
}

