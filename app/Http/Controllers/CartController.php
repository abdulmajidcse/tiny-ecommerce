<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['carts'] = Cart::with('product')
            ->whereHas('product')
            ->where('guest_id', session('guest_id'))
            ->get();

        return view('cart.index', $data);
    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(?Cart $cart = null)
    {
        if ($cart) {
            // only specific cart of this guest
            $cart->guest_id == session('guest_id') && $cart->delete();
            $message = 'Cart Item Deleted Successfully!';
        } else {
            // delete all carts of this guest
            Cart::where('guest_id', session('guest_id'))->delete();
            $message = 'Cart Deleted Successfully!';
        }

        return back()->with(['message' => $message, 'type' => 'success']);
    }
}
