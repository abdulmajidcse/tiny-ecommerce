<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['categories'] = Category::withCount('products')->latest()->paginate(10);

        return view('category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:190', Rule::unique(Category::class)],
        ]);

        Category::create($validatedData);

        return redirect()->route('categories.index')->with(['message' => 'Category Created Successfully!', 'type' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.create', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:190', Rule::unique(Category::class)->ignore($category->id)],
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.index')->with(['message' => 'Category Updated Successfully!', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->products->count() > 0) {
            $toast = [
                'message' => 'This category is associated with a product. Can not delete it!',
                'type' => 'error',
            ];
        } else {
            $category->delete();
            $toast = [
                'message' => 'Category Deleted Successfully!',
                'type' => 'success',
            ];
        }

        return redirect()->route('categories.index')->with($toast);
    }
}
