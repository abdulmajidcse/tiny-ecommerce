<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['name'] = $request->query('name');
        $data['email'] = $request->query('email');
        $data['mobile'] = $request->query('mobile');

        $orderQuery = Order::query();

        if ($data['name']) {
            // search with customer name
            $orderQuery->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        if ($data['email']) {
            // search with customer email
            $orderQuery->where('email', 'LIKE', '%' . $data['email'] . '%');
        }

        if ($data['mobile']) {
            // search with customer mobile
            $orderQuery->where('mobile', 'LIKE', '%' . $data['mobile'] . '%');
        }

        $data['orders'] = $orderQuery->latest()->paginate(10);

        return view('order.index', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $data['order'] = $order->load('OrderDetails.product');

        return view('order.show', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'approved', 'canceled', 'processing', 'order placed', 'on the way', 'delivered'])],
        ]);

        $order->update($validatedData);

        return back()->with(['message' => 'Order Updated Successfully!', 'type' => 'success']);
    }
}
