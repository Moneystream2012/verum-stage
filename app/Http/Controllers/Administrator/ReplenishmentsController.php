<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\ReplenishmentsDataTable;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Http\Controllers\Controller;
use App\Replenishment;
use App\User;
use Illuminate\Http\Request;

class ReplenishmentsController extends Controller
{
    public function index(ReplenishmentsDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.replenishments.index');
    }

    public function replenish(Request $request, User $user)
    {
        $this->validate($request, [
            'amount'                => 'required|numeric',
            'replenishment_balance' => 'required|in:balance,mining_balance',
        ]);
        $amount = $request->input('amount');
        $to = $request->input('replenishment_balance');
        $currency = 'USD';

        if ($to == 'mining_balance') {
            $currency = 'VMC';
        }

        $user->replenishments()->create([
            'id'          => Replenishment::generateID(),
            'amount'      => $amount,
            'currency'    => $currency,
            'to'          => $to,
            'cost_amount' => 0,
            'method'      => 'admin',
            'status'      => 'paid',
        ]);

        $user->investBalance($to, $amount);
        flash()->success('Счет: '.$to.' пополнен на '.$amount.' '.$currency)->important();

        return redirect()->back();
    }

    public function subtract(Request $request, User $user)
    {
        $this->validate($request, [
            'amount'                => 'required|numeric',
            'replenishment_balance' => 'required|in:balance,mining_balance',
        ]);
        $amount = -$request->input('amount');
        $to = $request->input('replenishment_balance');
        $currency = 'USD';

        if ($to == 'mining_balance') {
            $currency = 'VMC';
        }

        $user->replenishments()->create([
            'id'          => Replenishment::generateID(),
            'amount'      => $amount,
            'currency'    => $currency,
            'to'          => $to,
            'cost_amount' => 0,
            'method'      => 'admin',
            'status'      => 'paid',
        ]);

        $user->investBalance($to, $amount);
        flash()->success('Счет: '.$to.' вычтен на '.$amount.' '.$currency)->important();

        return redirect()->back();
    }
}
