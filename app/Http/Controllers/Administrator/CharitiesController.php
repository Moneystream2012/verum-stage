<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\CharitiesDataTable;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Http\Controllers\Controller;

class CharitiesController extends Controller
{
    public function index(CharitiesDataTable $dataTable, $user_id = null)
    {
        return $dataTable->addScope(new UserIdDataTableScope($user_id))->render('administrator.charities.index');
    }
}
