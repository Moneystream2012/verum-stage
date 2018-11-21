<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\ExchangesDataTable;
use App\DataTables\Scopes\FromMethodDataTableScope;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Http\Controllers\Controller;

class ExchangesController extends Controller
{
    public function index(ExchangesDataTable $dataTable, $user_id = null, $from_method = null)
    {
        return $dataTable
            ->addScope(new UserIdDataTableScope($user_id))
            ->addScope(new FromMethodDataTableScope($from_method))
            ->render('administrator.exchanges.index');
    }
}
