<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Replenishment;
use charlesassets\LaravelPerfectMoney\PerfectMoney;
use CoinGate\CoinGate;
use CoinGate\Merchant\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;

class ReplenishmentPayController extends Controller
{
    public function show()
    {
        $data = auth()->user()->replenishments()->where('method', '<>', 'admin')->latest()->get();

        return view('unify.personal-office.finance.replenishment', [
            'data' => $data,
            'coefficient' => [
                'usd' => config('mlm.replenishments.usd.coefficient') * 100,
            ],
            'min' => [
                'usd' => config('mlm.replenishments.usd.min')
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws ValidationException
     */
    public function replenish(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min_amount:USD,' . config('mlm.replenishments.usd.min'),
            'method' => 'required|in:bitcoin,verumcoin,advcash,yandex-money',
            'type_balance' => 'required|in:balance,mining_balance',
        ]);

        $method = $request->input('method');
        $type_balance = $request->input('type_balance');

        /*if (in_array($method, ['perfect_money', 'advcash', 'verumcoin']) && $type_balance != 'mining_balance') {
            flash()->error(trans('unify/personal-office/finance/replenishment.ex_error'));

            return redirect()->back();
        }*/
        if ($method == 'verumcoin') return $this->ecommerce($request);

        $amount = round($request->input('amount'), 2);
        $cost_amount = round($amount * config('mlm.replenishments.usd.coefficient'), 2);

        $order = (object)[
            'replenishment_id' => Replenishment::generateID(),
            'status' => 'processing',
            'currency' => 'USD',
            'token' => str_random(16),
            'amount' => $amount,
            'cost_amount' => $cost_amount,
            'full_amount' => $amount + $cost_amount,
        ];

        if ($method == 'bitcoin') {
            $order_bitcoin = $this->bitcoin($order);
        }

        auth()->user()->replenishments()->create([
            'id' => $order->replenishment_id,
            'currency' => $order->currency,
            'amount' => $order->amount,
            'to' => $type_balance,
            'cost_amount' => $order->cost_amount,
            'method' => $method,
            'payment_url' => $order_bitcoin->payment_url ?? '#',
            'payment_id' => $order_bitcoin->id ?? $order->replenishment_id,
            'token' => $order->token,
            'status' => $order->status,
        ]);

        switch ($method) {
            case 'bitcoin':
                return redirect($order_bitcoin->payment_url);
                break;
            case 'perfect_money':
                return $this->perfect_money($order);
                break;
            case 'walletone':
                return $this->walletone($order);
                break;
            case 'advcash':
                return $this->advcash($order);
                break;
            case 'yandex-money':
                return $this->yandexMoney($order);
                break;
            default:
                flash()->error('Error replenishment.');
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $method
     * @throws \Exception
     */
    public function callback(Request $request, $method)
    {
        if ($method == 'bitcoin') {
            $order_id = $request->input('order_id');
        } elseif ($method == 'perfect_money') {
            $order_id = $request->input('PAYMENT_ID');
        } elseif ($method == 'yandex-money') {
            $order_id = $request->input('label');
        }

        $order_id = (int)$order_id;

        $replenishment = Replenishment::findOrFail($order_id);

        if ($replenishment->status == 'paid') {
            return;
        }

        if ($request->input('token') == $replenishment->token || $method == 'yandex-money') {
            $status = null;
            $amount = $replenishment->cost_amount + $replenishment->amount;
            if ($method == 'bitcoin') {
                if ($request->input('price') >= $amount && $request->input('status') == 'paid') {
                    $status = 'paid';
                    $replenishment->pay();
                } else {
                    $status = $request->input('status');
                }
                if ($status == 'canceled') {
                    $status = null;
                    $replenishment->delete();
                }
            } elseif ($method == 'perfect_money') {
                $perfectmoney = new PerfectMoney();
                if ($perfectmoney->generateHash($request) == $request->input('V2_HASH') &&
                    round($request->input('PAYMENT_AMOUNT'), 2) >= round($amount, 2)) {
                    $status = 'paid';
                    $replenishment->pay();
                } else {
                    $status = 'invalid';
                }
            } elseif ($method == 'yandex-money') {
                $secret_key = '+uJ6FP7iWIv3porn1G2Ng7mh'; // секретное слово, которое мы получили в предыдущем шаге.
                $sha1 = sha1($_POST['notification_type']
                    . '&' . $_POST['operation_id']
                    . '&' . $_POST['amount'] . '&643&' . $_POST['datetime']
                    . '&' . $_POST['sender'] . '&' . $_POST['codepro']
                    . '&' . $secret_key . '&' . $_POST['label']);

                if ($sha1 == $request->input('sha1_hash')) {
                    $status = 'paid';
                    $replenishment->payment_url = $_POST['operation_label'] . ':' . $_POST['operation_id'] ?? '#';
                    $replenishment->payment_id = $_POST['label'];
                    $replenishment->pay();
                } else {
                    $status = 'invalid';
                }
            }

            if (!is_null($status)) {
                $replenishment->update(['status' => $status]);
            }
        }
    }

    public function success(int $id)
    {
        flash()->success(trans('unify/personal-office/finance/replenishment.pay_success') . ' #' . $id)->important();

        return redirect()->route('personal-office.replenishment.index');
    }

    public function fail(Request $request, int $id)
    {
        if ($request->isMethod('POST') && $request->exists('token')) {
            $replenishment = Replenishment::findOrFail($id);
            if ($request->input('token') == $replenishment->token) {
                $replenishment->delete();
            }
        }

        flash()->error(trans('unify/personal-office/finance/replenishment.pay_fail') . ' #' . $id)->important();

        return redirect()->route('personal-office.replenishment.index');
    }

    public function ecommerce(Request $request)
    {
        $amount_usd = $request->input('amount', 0);
        $address = auth()->user()->address;
        $qr_code = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=' . $address . '&.png';

        return view('unify.personal-office.ecommerces.verumcoin', [
            'amount_usd' => $amount_usd,
            'amount_vmc' => USDtoVMC($amount_usd),
            'address' => $address,
            'qr_code' => $qr_code,
        ]);
    }

    private function bitcoin($order)
    {
        CoinGate::config([
            'app_id' => '5100',
            'api_key' => 'pavkNOyogHmzDfUqZ2iBXt',
            'api_secret' => 'QHcdjJpu6g0rqaYyB9XDMsO1fFoLCme5',
        ]);
        //CoinGate::config([
        //    'app_id'     => '3341',
        //    'api_key'    => 'v8giVPdUGm1ytlx64jATw0',
        //    'api_secret' => 'HlJLvBb9fW286tEKVkXqNu4xM5QPYcDi',
        //]);

        return Order::create([
            'order_id' => $order->replenishment_id,
            'price' => $order->full_amount,
            'currency' => $order->currency,
            'receive_currency' => 'BTC',
            'title' => config('app.name'),
            'description' => route('home'),
            'callback_url' => route('personal-office.replenishment.callback', [
                'method' => 'bitcoin',
                'token' => $order->token,
            ]),
            'success_url' => route('personal-office.replenishment.success', ['id' => $order->replenishment_id]),
            'cancel_url' => route('personal-office.replenishment.fail', ['id' => $order->replenishment_id]),
        ]);
    }

    private function perfect_money($order)
    {
        return PerfectMoney::render([
            'PAYMENT_AMOUNT' => $order->full_amount,
            'SUGGESTED_MEMO' => formatCurrency($order->currency, $order->amount, true),
            'PAYEE_NAME' => config('app.name'),
            'PAYMENT_ID' => $order->replenishment_id,
            'PAYMENT_UNITS' => $order->currency,
            'STATUS_URL' => route('personal-office.replenishment.callback', [
                'method' => 'perfect_money',
                'token' => $order->token,
            ]),
            'PAYMENT_URL' => route('personal-office.replenishment.success', ['id' => $order->replenishment_id]),
            'NOPAYMENT_URL' => route('personal-office.replenishment.fail', [
                'id' => $order->replenishment_id,
                'token' => $order->token,
            ]),
        ]);
    }

    private function walletone($order)
    {
        $key = "5d4230324562716d7b42326f317c377b6660714f6b535c4c6c3635";
        $fields["WMI_MERCHANT_ID"] = "189559722284";
        $fields["WMI_PAYMENT_AMOUNT"] = $order->full_amount;
        $fields["WMI_CURRENCY_ID"] = "840";
        $fields["WMI_PAYMENT_NO"] = $order->replenishment_id;
        $fields["WMI_DESCRIPTION"] = "BASE64:" . base64_encode("Payment for order #" . $order->replenishment_id);
        $fields["WMI_EXPIRED_DATE"] = \Carbon\Carbon::now('UTC')->addDays(10)->toIso8601String();

        //Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
        //$fields["WMI_PTENABLED"]      = array("UnistreamRUB", "SberbankRUB", "RussianPostRUB");

        $fields["WMI_SUCCESS_URL"] = route('personal-office.replenishment.success', ['id' => $order->replenishment_id,
            'token' => $order->token,
        ]);
        $fields["WMI_FAIL_URL"] = route('personal-office.replenishment.fail', [
            'id' => $order->replenishment_id,
            'token' => $order->token,
        ]);
        uksort($fields, "strcasecmp");
        $fields["WMI_SIGNATURE"] = base64_encode(pack("H*", md5(implode('', $fields) . $key)));

        $data = [
            'action' => 'https://wl.walletone.com/checkout/checkout/Index',
            'fields' => $fields,
        ];

        return view('unify.personal-office.replenishment-forms.walletone', compact('data'));
    }

    private function yandexMoney($order)
    {
        $fields["receiver"] = "410016147146233";
        $fields["targets"] = "Payment for order #" . $order->replenishment_id . ', amount: ' . formatCurrency($order->currency, $order->amount, true);
        $fields["formcomment"] = $fields["targets"];
        $fields["short-dest"] = $fields["targets"];
        $fields["label"] = $order->replenishment_id;
        $fields["quickpay-form"] = 'shop';
        $fields["sum"] = (string)USDtoRUB($order->full_amount);
        $fields["need-fio"] = 'false';
        $fields["need-email"] = 'false';
        $fields["need-phone"] = 'false';
        $fields["need-address"] = 'false';
        $fields["paymentType"] = 'AC';
        $fields["successURL"] = route('personal-office.replenishment.success', [
            'id' => $order->replenishment_id,
        ]);

        $data = [
            'action' => 'https://money.yandex.ru/quickpay/confirm.xml',
            'fields' => $fields,
        ];

        return view('unify.personal-office.replenishment-forms.yandex-money', compact('data'));
    }

    private function advcash($order)
    {
        $sign = hash('sha256', config('advcash.account_email') .
            ':' . config('advcash.sci_name') .
            ':' . $order->full_amount .
            ':' . $order->currency .
            ':' . config('advcash.sci_password') .
            ':' . $order->replenishment_id);

        return view('sci.advcash', [
            'sign' => $sign,
            'amount' => $order->full_amount,
            'order_id' => $order->replenishment_id,
            'currency' => $order->currency,
            'comments' => formatCurrency($order->currency, $order->amount, true),
            'success_url' => route('personal-office.replenishment.success', ['id' => $order->replenishment_id]),
            'fail_url' => route('personal-office.replenishment.fail', [
                'id' => $order->replenishment_id,
                'token' => $order->token,
            ]),
            'status_url' => route('personal-office.replenishment.callback', [
                'method' => 'advcash',
                'token' => $order->token,
            ]),
        ]);
    }

}
