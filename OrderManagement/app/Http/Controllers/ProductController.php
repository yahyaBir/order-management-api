<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products=Product::paginate(10);
        if ($products){
            $products->getCollection()->transform(function ($product) {
                return [
                    'product_title' => $product->product_title,
                    'list_price' => $product->list_price,
                    'category_id' => $product->category_id,
                    'category_title' => $product->category->category_title, //category relationship başarılı
                    'author' => $product->author,
                    'stock_quantity' => $product->stock_quantity,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ];
            });
            return response()->json($products,200);
        }
        else return response()->json('no products');
    }

    public function show($id){
        $product=Product::find($id);
        if ($product){
            return response()->json($product, 200);
        }
        else return response()->json('product was not found');
    }

    public function store(Request $request){
        Validator::make($request->all(),[
            'product_title'=> 'required',
            'list_price'=> 'required|numeric',
            'category_id'=> 'required|numeric',
            'author'=> 'required',
            'stock_quantity'=> 'required|numeric'
        ]);
        $product=new Product();
        $product->product_title=$request->product_title;
        $product->list_price=$request->list_price;
        $product->category_id=$request->category_id;
        $product->author=$request->author;
        $product->stock_quantity=$request->stock_quantity;

        $product->save();
        return response()->json('product is added',201);
    }

    public function update($id,Request $request){
        $validated = $request->validate([
            'product_title' => 'nullable',
            'list_price' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'author' => 'nullable|string',
            'stock_quantity' => 'nullable|numeric'
        ]);

        $product=Product::find($id);
        if ($product){
            $product->fill($request->only([
                'product_title',
                'list_price',
                'category_id',
                'author',
                'stock_quantity'
            ]));
            $product->save();
            return response()->json('product updated',200);
        }
        else return response()->json('product not found');
    }
    public function destroy($id){
        $product= Product::find($id);
        if ($product){
            $product->delete();
            return response()->json('product deleted');
        }
        else return response()->json('product not found');
    }

}

