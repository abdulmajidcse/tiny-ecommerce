<?php

namespace App\Http\Controllers;

use App\Models\Product;

class FrontendController extends Controller
{
    public function index()
    {
        $data['products'] = Product::with('category')->latest()->paginate(10);

        return view('home', $data);
    }

    public function productDetails(Product $product)
    {
        $data['product'] = $product->load('category');

        return view('product-details', $data);
    }
}
