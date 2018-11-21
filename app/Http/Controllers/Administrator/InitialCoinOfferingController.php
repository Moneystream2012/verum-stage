<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\InitialCoinOfferingsDataTable;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Http\Controllers\Controller;

class InitialCoinOfferingController extends Controller
{
    public function index(InitialCoinOfferingsDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.ico.index');
    }
}
