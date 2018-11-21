<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\WithdrawsDataTable;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Jobs\User\Histories;
use App\Withdraw;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class WithdrawsController extends Controller
{
    public function index(WithdrawsDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.withdraws.index');
    }

    public function payout($id, $tx)
    {
        $withdraw = Withdraw::whereId($id)->where('status', Withdraw::STATUS_PROCESSING)->firstOrFail();

        $withdraw->update([
            'tx'      => $tx,
            'status'  => Withdraw::STATUS_SUCCESS,
            'done_at' => Carbon::now(),
        ]);

        dispatch(new Histories($withdraw->user_id, 'withdraw-success', 'requests', [
            'id'     => $withdraw->id,
            'to'     => $withdraw->wallet_address,
            'amount' => formatUSD($withdraw->amount),
            'tx'     => $tx,
        ]));

        return response()->json(['msg' => 'Заявка принята.'], 200);
    }

    public function rejection($id)
    {
        $withdraw = Withdraw::whereId($id)->where('status', Withdraw::STATUS_PROCESSING)->firstOrFail();
        $amount = round($withdraw->amount + $withdraw->cost_amount, 2);

        $withdraw->user->investBalance($withdraw->from_method, $amount);

        $withdraw->update([
            'status'  => Withdraw::STATUS_REJECTION,
            'done_at' => Carbon::now(),
        ]);

        dispatch(new Histories($withdraw->user_id, 'withdraw-rejection', 'requests', [
            'id'     => $withdraw->id,
            'to'     => $withdraw->from_method,
            'amount' => formatUSD($amount),
        ]));

        return response()->json(['msg' => 'Заявка отклонена.']);
    }
}
