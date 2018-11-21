<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\RewardsDataTable;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Http\Controllers\Controller;

class RewardsController extends Controller
{
    public function index(RewardsDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.rewards.index');
    }
}
