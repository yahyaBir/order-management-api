<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
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
        $this->middleware('is_admin', ['only' => ['destroy']]);
    }
    public function index() {
        $user = auth()->user();

        if ($user->is_admin == 1) {
            $orders = Order::paginate(20);
        } else {
            $orders = Order::where('user_id', $user->id)->paginate(20);
        }
        return response()->json([
            'status' => 'success',
            'message' => $orders->isEmpty() ? 'No orders found.' : 'Orders retrieved successfully.',
            'data' => $orders->isEmpty() ? [] : OrderResource::collection($orders),
        ], 200);
    }

    public function show($id)
    {
        try {
            $orderDetail = $this->orderDetailService->getOrderDetail($id);

            if (!$orderDetail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The requested order could not be found.',
                ], 404);
            }
            $order = Order::find($id);

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found.',
                ], 404);
            }
            if (auth()->user()->is_admin === 0 && auth()->user()->id !== $order->user_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized to access this order.',
                ], 403);
            }
            return response()->json($orderDetail, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
                'timestamp' => now()->toDateTimeString(),
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

