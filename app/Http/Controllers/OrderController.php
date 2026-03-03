<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        $orders = Order::where('status', 'active')->get();

        return view('orders', compact('orders'));
    }

    public function stripe(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer'
        ]);

        $name = $request->name;
        $price = $request->price;
        
        return view('stripe', compact('name', 'price'));
    }
}
