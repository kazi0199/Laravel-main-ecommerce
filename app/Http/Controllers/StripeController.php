<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function stripeProcess($order_id, $amount, $name = "E-commerce Payment", $qty = 1)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));


        $name = is_object($name) ? ($name->name ?? $name->title ?? 'Order Payment') : $name;
        $order_id = is_object($order_id) ? ($order_id->id ?? '') : $order_id;
        $qty = (int) $qty;

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => (string) $name,
                        ],
                        'unit_amount' => $amount * 100,
                    ],
                    'quantity' => $qty,
                ]
            ],
            'mode' => 'payment',
            'metadata' => [
                'order_id' => (string) $order_id,
            ],
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);


        return redirect()->away($session->url);

    }

    public function stripeSuccess(Request $request)
    {
        $session = \Stripe\Checkout\Session::retrieve($request->session_id);
        
        $order = Order::find($session->metadata->order_id);
       
        return $order;
    }



    public function stripeCancel()
    {
        return view('stripe.cancel');   
    }
}
