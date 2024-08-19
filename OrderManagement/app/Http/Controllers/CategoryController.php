<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        $category= Category::paginate(10);
        if ($category->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No categories found in the current page of results.',
            ], 404);
        }
        else return response()->json(['status' => 'success', $category], 200);
    }

    public function show($id){
        try {
            $category = Category::findOrFail($id);
            return response()->json(['status'=>'success',$category, 200]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error',
                    'message' => "Category with ID {$id} not found.",
                ], 404);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'category_title' => 'required|string|unique:categories,category_title'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $category = new Category();
            $category->category_title = $request->category_title;
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Category successfully created',
                'data' => $category
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_title' => 'required|unique:categories,category_title'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 400);
            }

            $category = Category::findOrFail($id);
            $category->fill($request->only('category_title'));
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully',
                'data' => $category
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Category with ID {$id} not found."
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => "Category with ID {$id} successfully deleted"
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Category with ID {$id} not found."
            ], 404);
        }
    }
}
