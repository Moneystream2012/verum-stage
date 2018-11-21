<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\TransfersDataTable;
use App\DataTables\Scopes\ToIdDataTableScope;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Http\Controllers\Controller;

class TransfersController extends Controller
{
    public function index(TransfersDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.transfers.index');
    }

    public function have(TransfersDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new ToIdDataTableScope($user_id))->render('administrator.transfers.index');
    }
}
