<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\SharesDataTable;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Http\Controllers\Controller;

class SharesController extends Controller
{
    public function index(SharesDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.shares.index');
    }
}
