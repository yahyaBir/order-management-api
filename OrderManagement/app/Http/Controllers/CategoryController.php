<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $category= Category::paginate(10);
        return response()->json($category,200);
    }

    public function show($id){
        $category= Category::find($id);
        if ($category){
            return response()->json($category,200);
        }
        else return response()->json('Category is not found');
    }

    public function store(Request $request){
        try {
            $validated = $request->validate([
                'category_title'=>'required|unique:categories,category_title'
            ]);
            $category= new Category();
            $category->category_title = $request->category_title;
            $category->save();
            return response()->json('Category added', 201);
        }
        catch (Exception $e){
            return response()->json($e,500);
        }
    }

    public function update($id,Request $request){
        try {
            $validated = $request->validate([
                'category_title'=>'required|unique:categories,category_title'
            ]);
            Category::where('id',$id)->update(['category_title'=>$request->category_title]);
            return response()->json('Category updated',200);
        }
        catch (Exception $e){
            return response()->json($e,500);
        }
    }
    public function destroy($id){
        $category= Category::find($id);
        if ($category){
            $category->delete();
            return response()->json('category deleted');
        }
        else return response()->json('Category not found');
    }
}
