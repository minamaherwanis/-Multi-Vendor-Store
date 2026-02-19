<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payments.create', [
            'order' => $order,
        ]);
    }

    public function createStripePaymentIntent(Order $order)
    {
        // حساب المبلغ بالدولار
        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Stripe بيشتغل بالـ cents
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        try {
            // إنشاء سجل الدفع
            Payment::create([
                'order_id' => $order->id,
                'amount' => $paymentIntent->amount,
                'currency' => $paymentIntent->currency,
                'method' => 'stripe',
                'status' => 'pending',
                'transaction_id' => $paymentIntent->id,
                'transaction_data' => json_encode($paymentIntent),
            ]);
        } catch (QueryException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    public function confirm(Request $request, Order $order)
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );

        if ($paymentIntent->status === 'succeeded') {
            try {
                $payment = Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'amount' => $paymentIntent->amount,
                        'currency' => $paymentIntent->currency,
                        'method' => 'stripe',
                        'status' => 'completed',
                        'transaction_id' => $paymentIntent->id,
                        'transaction_data' => json_encode($paymentIntent),
                    ]
                );

                event('payment.created', $payment->id);

                return redirect()->route('home', [
                    'status' => 'payment-succeeded'
                ]);
            } catch (QueryException $e) {
                return back()->withErrors(['error' => $e->getMessage()]);
            }
        }

        return redirect()->route('orders.payments.create', [
            'order' => $order->id,
            'status' => $paymentIntent->status,
        ]);
    }
}