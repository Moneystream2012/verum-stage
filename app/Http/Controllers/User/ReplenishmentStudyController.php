<?php

namespace App\Http\Controllers\User;

use App\Mail\Users\PaymentStudy;
use CoinGate\CoinGate;
use CoinGate\Merchant\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplenishmentStudyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replenish(Request $request)
    {
        CoinGate::config([
            'app_id'     => '5507',
            'api_key'    => '8aPuGKxTwVAr9ycZ3n2zvN',
            'api_secret' => 'lgTBcsASv7a8QjxO1kC5nyHdI0qVJmeE',
        ]);

        $order_id = $request->input('order_id', '1');
        $price = $request->input('price', '1');
        $email = $request->input('email', 'ridiks100@gmail.com');
        $first_name = $request->input('first_name', 'Andrew');

        $order = Order::create([
            'order_id'         => (int) $order_id,
            'price'            => (float) $price,
            'currency'         => 'USD',
            'receive_currency' => 'BTC',
            'title'            => 'Demo',
            'description'      => 'Demo',
            'callback_url'     => url('study.verumtrade.com/?secret=123',
                [
                    'order_id'   => $order_id,
                    'email'      => $email,
                    'first_name' => $first_name,
                ]),
            'success_url'      => url('https://study.verumtrade.com?success_id='. $order_id),
            'cancel_url'       => url('https://study.verumtrade.com?cancel_id='. $order_id),
        ]);
        if ($order) {
            return redirect($order->payment_url);
        }
    }

    public function callback(Request $request)
    {
        if ($request->input('status')) {
            \Log::alert('callback', $request->all());
            Mail::to($request->input('email'))->send(new PaymentStudy($request->all()));
        }
    }

    public function success(int $id)
    {
        return 'Pay success. #'.$id;
    }

    public function fail(int $id)
    {
        return 'Pay fail. #'.$id;
    }
}
