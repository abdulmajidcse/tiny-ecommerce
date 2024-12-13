<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductService
{
    public function getProducts(Request $request)
    {
        $data['category_id'] = $request->query('category_id');
        $data['name'] = $request->query('name');
        $data['categories'] = Category::select('id', 'name')->oldest('name')->get();

        $productQuery = Product::with('category');

        if ($data['category_id']) {
            // search with category
            $productQuery->where('category_id', $data['category_id']);
        }

        if ($data['name']) {
            // search with product name
            $productQuery->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        $data['products'] = $productQuery->latest()->paginate(10);

        return $data;
    }
}