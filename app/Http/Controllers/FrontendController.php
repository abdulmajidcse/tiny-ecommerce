<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request, ProductService $productService)
    {
        return view('home', $productService->getProducts($request));
    }

    public function productDetails(Product $product)
    {
        $data['product'] = $product->load('category');

        return view('product-details', $data);
    }
}
