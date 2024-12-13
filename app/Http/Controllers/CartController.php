<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Store or update cart item
     */
    public function storeOrUpdate(Request $request, Product $product)
    {
        $quantity = intval($request->input('quantity'));
        if ($quantity < 1) {
            // validate quantity
            return back()->with(['message' => 'Product quantity must be at least 1.', 'type' => 'error']);
        }

        if ($product->stock_quantity < $quantity) {
            // checkt stock quantity availabilty
            return back()->with(['message' => 'The stock quantity is ' . $product->stock_quantity . ' only!', 'type' => 'error']);
        }

        // get existing cart of this visitor
        $cart = $product->carts()->where('guest_id', session('guest_id'))->first();

        if ($cart) {
            if ($product->stock_quantity < ($quantity + $cart->quantity)) {
                // checkt stock quantity availabilty
                return back()->with(['message' => 'The stock quantity is ' . $product->stock_quantity . ' only!', 'type' => 'error']);
            }

            // update existing cart item quantity
            $cart->update([
                'quantity' => $quantity + $cart->quantity,
            ]);

            $message = 'Item updated to your cart successfully.';
        } else {
            // store new cart item
            $product->carts()->create([
                'ip' => $request->ip(),
                'guest_id' => session('guest_id'),
                'quantity' => $quantity,
            ]);

            $message = 'New item added to your cart successfully.';
        }

        return back()->with(['message' => $message, 'type' => 'success']);
    }
}
