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

        // $session = $stripe->checkout->sessions->create([
        //     'payment_method_types' => ['card'],
        //     'line_items'           => $lineItems,
        //     'mode'                 => 'payment',
        //     'success_url'          => config('app.frontend_url') . '/order/success?order_id=' . $order->id,
        //     'cancel_url'           => config('app.frontend_url') . '/order/cancel?order_id=' . $order->id,
        //     'metadata'             => ['order_id' => $order->id],
        // ]);

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
