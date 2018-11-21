<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\TradingDataTable;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Http\Controllers\Controller;
use App\Trading;
use Illuminate\Http\Request;

class TradingController extends Controller
{
    public function index(TradingDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.trading.index');
    }

    public function update()
    {
        return view('administrator.trading.update', [
            'percent' => Trading::getPercentPayout()
        ]);
    }

    public function updatePercent(Request $request)
    {
        Trading::setPercentPayout($request->input('percent'));
        flash()->success('Обновлено');
        return redirect()->back();
    }

    public function closed(Trading $trading)
    {
        flash()->success('Пакет #'.$trading->id . ' закрыт!');
        $trading->status = Trading::REFUND;
        $trading->save();
        return redirect()->back();
    }
}
