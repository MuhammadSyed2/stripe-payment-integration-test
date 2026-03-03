<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    //
    public function index()
    {
        $orders = Order::where('status', 'active');

        return view('orders');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $charge = $stripe->charges->create([
            'amount' => $request->price * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => "test integration"
        ]);

        return back()->with("success", "payment completed");
    }
}
