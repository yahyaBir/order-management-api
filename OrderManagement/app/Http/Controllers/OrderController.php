<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderDetailService;
use App\Services\OrderService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{



    protected $orderService;

    public function __construct(OrderService $orderService, OrderDetailService $orderDetailService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
        $this->middleware('auth');

        $this->middleware('is_admin', ['only' => ['store', 'update', 'destroy']]);

    }
    public function index() {
        $orders = Order::paginate(20);
        if ($orders->isNotEmpty()) {
            foreach ($orders->items() as $order) {
                //dd($order);
                    $product = Product::find($order['product_id']);
                    //dd($product);
                    $order->product_id = $product;
            }
            return response()->json($orders, 200);
        } else {
            return response()->json('There are no new orders');
        }
    }
    public function show($id)
    {
        try {
            $orderDetail = $this->orderDetailService->getOrderDetail($id);

            if (!$orderDetail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found',
                ], 404);
            }
            $order = Order::find($id);

                if (!$order || auth()->user()->id != $order->user_id) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Unauthorized',
                    ], 401);
                }

            return response()->json($orderDetail, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    function store(Request $request)
    {
        try {
            $order = DB::transaction(function () use ($request) {
                return $this->orderService->createOrder($request->all());
            });

            return response()->json([
                'order' => $order,
            ], 201);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
     public function destroy($id){
         try {
             $order = Order::findOrFail($id);
             $order->delete();

             return response()->json([
                 'status' => 'success',
                 'message' => "Product with ID {$id} successfully deleted"
             ], 200);
         } catch (ModelNotFoundException $e) {
             return response()->json([
                 'status' => 'error',
                 'message' => "Product with ID {$id} not found.",
             ], 404);
         }
     }
}

