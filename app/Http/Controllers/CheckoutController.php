<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
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

        if ($data['carts']->count() < 1) {
            // back to home when cart is empty
            return redirect('/')->with(['message' => 'Your cart is empty! Please, add to cart for placing an order.']);
        }

        return view('checkout.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'mobile' => ['required', 'numeric', 'digits:11', 'starts_with:01'],
            'address' => ['required', 'string', 'max:5000'],
        ], [], [
            'category_id' => 'category',
        ]);

        $validatedData['ip'] = $request->ip();
        // just init, it'll replace end
        $validatedData['sub_total'] = 0;
        $validatedData['status'] = 'pending';

        // get carts of this guest
        $carts = Cart::with('product')
            ->whereHas('product')
            ->where('guest_id', session('guest_id'))
            ->get();

        // store a new order
        DB::beginTransaction();
        try {
            $order = Order::create($validatedData);
            $subTotal = 0;
            foreach ($carts as $cart) {
                if ($cart->product->stock_quantity < $cart->quantity) {
                    // cancel the order
                    DB::rollBack();
                    // delete old carts
                    Cart::where('guest_id', session('guest_id'))->delete();
                    // delete guest_id from session
                    session()->forget('guest_id');

                    return redirect('/')->with(['message' => 'Your order is canceled. Because, some products are not available currently. Please, try to place another order. Thank you!', 'type' => 'error']);
                }

                // calculate price
                $subTotal += ($cart->product->price * $cart->quantity);

                // decrease product quantity
                $decreaseProductQuantity = $cart->product->stock_quantity - $cart->quantity;
                $cart->product->update([
                    'stock_quantity' => $decreaseProductQuantity > 0 ? $decreaseProductQuantity : 0,
                ]);

                $order->OrderDetails()->create([
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'selling_price' => $cart->product->price,
                ]);
            }

            // update order sub total
            $order->update(['sub_total' => $subTotal]);

            // delete old carts
            Cart::where('guest_id', session('guest_id'))->delete();

            DB::commit();

            // delete guest_id from session
            session()->forget('guest_id');

            return redirect('/')->with(['message' => 'Your Order Placed Successfully! We will contact you soon. Thank you!', 'type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/')->with(['message' => $th->getMessage(), 'type' => 'error']);
        }
    }
}
