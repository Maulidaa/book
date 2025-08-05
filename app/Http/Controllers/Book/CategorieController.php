<?php

namespace App\Http\Controllers\Book;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CategorieController extends Controller
{
    public function index()
    {
        // Logic to list paginated categories
        $categories = Category::paginate(10);
        $page = request()->get('page', 1);
        $categories->setPath(route('categories.index', ['page' => $page])); 
        return response()->json($categories);
        
    }

    public function show($id)
    {
        // Logic to show a specific category
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Logic to create a new category
        $category = Category::create([
            'name' => $request->name,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Logic to update an existing category
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        
        $category->name = $request->name;
        $category->save();

        return response()->json($category);
    }

    public function destroy($id)
    {
        // Logic to delete a category
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
