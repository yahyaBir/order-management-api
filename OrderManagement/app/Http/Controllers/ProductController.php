<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products=Product::paginate(10);
        if ($products->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No products found in the current page of results.',
            ], 404);
        }
        else return response()->json(['status' => 'success', $products], 200);
    }

    public function show($id){
        try {
            $product = Product::findOrFail($id);
            return response()->json(['status'=>'success', $product, 200]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error',
                'message' =>"Product with ID {$id} not found.",
                ], 404);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'product_title' => 'required|string',
            'list_price' => 'required|numeric',
            'category_id' => 'required|numeric|exists:categories,id',
            'author' => 'required|string',
            'stock_quantity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        $product=new Product();
        $product->product_title=$request->product_title;
        $product->list_price=$request->list_price;
        $product->category_id=$request->category_id;
        $product->author=$request->author;
        $product->stock_quantity=$request->stock_quantity;

        $product->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Product successfully created',
            'data' => $product
        ], 201);
    }

    public function update($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_title' => 'nullable',
                'list_price' => 'nullable|numeric',
                'category_id' => 'nullable|numeric',
                'author' => 'nullable|string',
                'stock_quantity' => 'nullable|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 400);
            }
            $product = Product::findOrFail($id);
            $product->fill($request->only([
                'product_title',
                'list_price',
                'category_id',
                'author',
                'stock_quantity'
            ]));
            $product->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'data' => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Product with ID {$id} not found."
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json([
                'status' => 'success',
                'message' => "Product with ID {$id} successfully deleted"], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Product with ID {$id} not found.",
            ], 404);
        }
    }
}

