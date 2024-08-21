<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderService;
use Exception;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index() {
        $orders = Order::paginate(10);
        if ($orders->isNotEmpty()) {
            foreach ($orders->items() as $order) {
                    $product = Product::find($order['product_id']);
                    $order->product_id = $product;
            }
            return response()->json($orders, 200);
        } else {
            return response()->json('There are no new orders');
        }
    }
    public function show($id)
    {
            $order = Order::with('items')->find($id);
        if (!$order){return response()->json('yanlıs girdinşz',400);}
            return [
                'orderId' => $order->id,
                'totalAmount' => $order->total_amount,
                'discountedAmount' => $order->discounted_amount,
                'items' => $order->items->map(function($item) {
                    return [
                        'productId' => $item->product_id,
                        'quantity' => $item->quantity,
                    ];
                }),
                'shippingCost' => $order->shipping_cost,
                'appliedCampaign' => $order->applied_campaign,
                'status' => $order->status,
            ];
    }

    public function store(Request $request)
    {
        try {
            $result = $this->orderService->createOrder($request->all());

            if ($result['status'] === 'error') {
                return response()->json([
                    'status' => 'error',
                    'message' => $result['message'],
                    'errors' => $result['errors'] ?? null
                ], 400);
            }

            return response()->json($result['order'], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function user_orders($id){

        $orders=Order::with('items')
            ->where('user_id',$id)
            ->get();

        if ($orders){
            foreach ($orders as $order){
                foreach ($order->items as $order_items){
                    $product = Product::where('id', $order_items->product_id)->pluck('product_title');
                    $order_items->product_title = $product['0'];
                }
            }
            return response()->json($orders);
        }
        else return response()->json('no orders found for this user');
    }
}

