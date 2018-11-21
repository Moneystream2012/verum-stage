<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\DepositsDataTable;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Deposit;
use App\Extensions\GlobalSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositsController extends Controller
{
    public function index(DepositsDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.deposits.index');
    }

    public function update(GlobalSettings $globalSettings)
    {
        $products = collect(Deposit::PRODUCTS)->map(function ($item) use($globalSettings) {
            $item['percent'] = $globalSettings->get('plan_' . $item['plan'] . '_percent');
            return $item;
        });

        return view('administrator.deposits.update', compact('products'));
    }

    public function updatePercent(Request $request, GlobalSettings $globalSettings)
    {
        $date = collect($request->except('_token'));
        $date->each(function ($value, $key) use ($globalSettings) {
            if ($globalSettings->get($key) != $value) {
                $globalSettings->set($key, $value);
            }
        });
        flash()->success('Обновлено');
        return redirect()->back();
    }

    public function closed(Deposit $deposit)
    {
        flash()->success('Пакет #'.$deposit->id . ' закрыт!');
        $deposit->active = false;
        $deposit->old = true;
        $deposit->save();
        return redirect()->back();
    }
}
