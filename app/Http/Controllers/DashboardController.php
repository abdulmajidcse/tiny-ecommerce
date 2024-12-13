<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data['totalOrders'] = Order::count();
        $data['totalPendingOrders'] = Order::where('status', 'pending')->count();
        $data['totalDeliveredOrders'] = Order::where('status', 'delivered')->count();

        return view('dashboard', $data);
    }
}
