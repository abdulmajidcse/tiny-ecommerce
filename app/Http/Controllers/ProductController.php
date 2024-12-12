<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['products'] = Product::with('category')->latest()->paginate(10);

        return view('product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::select('id', 'name')->oldest('name')->get();

        return view('product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:190', Rule::unique(Product::class)],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'numeric', Rule::exists(Category::class, 'id')],
        ], [], [
            'category_id' => 'category',
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')->with(['message' => 'Product Created Successfully!', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $data['product'] = $product->load('category');

        return view('product.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $data['product'] = $product->load('category');
        $data['categories'] = Category::select('id', 'name')->oldest('name')->get();

        return view('product.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:190', Rule::unique(Product::class)->ignore($product->id)],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'numeric', Rule::exists(Category::class, 'id')],
        ], [], [
            'category_id' => 'category',
        ]);

        $product->update($validatedData);

        return redirect()->route('products.index')->with(['message' => 'Product Updated Successfully!', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->orderDetails->count() > 0) {
            $toast = [
                'message' => 'This product is associated with an order. Can not delete it!',
                'type' => 'error',
            ];
        } else {
            $product->delete();
            $toast = [
                'message' => 'Product Deleted Successfully!',
                'type' => 'success',
            ];
        }

        return redirect()->route('products.index')->with($toast);
    }
}
