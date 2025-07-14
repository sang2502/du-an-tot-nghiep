<?php

namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function history()
    {
        $orders = Order::where('user_id', session('user.id'))
            ->orderByDesc('created_at')
            ->get();
        return view('client.orders.order-history', compact('orders'));
    }

}

