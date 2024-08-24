<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::paginate(20);

        if ($authors->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No authors found in the current page of results.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'authors' => $authors
        ], 200);
    }

    public function show($id)
    {
        try {
            $author = Author::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'author' => $author
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Author with ID {$id} not found."
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:authors,name',
            'author_origin' => 'required|in:local,foreign'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $author = new Author();
            $author->name = $request->name;
            $author->author_origin = $request->author_origin;
            $author->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Author successfully created',
                'data' => $author
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the author',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|unique:authors,name,' . $id,
            'author_origin' => 'nullable|in:local,foreign'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $author = Author::findOrFail($id);
            $author->name = $request->input('name');
            $author->author_origin = $request->input('author_origin');
            $author->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Author updated successfully',
                'data' => $author
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Author with ID {$id} not found."
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
            $author = Author::findOrFail($id);
            $author->delete();

            return response()->json([
                'status' => 'success',
                'message' => "Author with ID {$id} successfully deleted"
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Author with ID {$id} not found."
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}

