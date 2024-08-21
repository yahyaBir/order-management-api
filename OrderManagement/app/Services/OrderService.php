<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use http\Env\Response;
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

        $totalAmount = 0;
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

                $totalAmount += $items->quantity * $items->price;
                $orderItems->push($items);

                $product->stock_quantity -= $order_item['quantity'];
                $product->save();
            } else {
                return ['status' => 'error', 'message' => 'Insufficient stock'];
            }
        }
        try {


        // Apply the best campaign
        $campaignResult = $this->campaignService->applyBestCampaign($orderItems, $totalAmount);

        $shippingCost = $campaignResult['discountedAmount'] > 50 ? 0 : 10;
        $totalAmount = $campaignResult['discountedAmount'] + $shippingCost + $order->discount_amount;

        $order->shipping_cost = $shippingCost;

        $order->discounted_amount = $campaignResult['discountedAmount'];
        $order->discount_amount = $campaignResult['discount'];
        $totalAmount = $campaignResult['discountedAmount'] + $shippingCost + $order->discount_amount;
        $order->total_amount = $totalAmount;
        $order->applied_campaign = $campaignResult['appliedCampaign'];
        $order->save();


        return ['status' => 'success', 'order' => $order];
        }catch (\Exception $e){
            return response()->json($e,500);
        }
    }
}

