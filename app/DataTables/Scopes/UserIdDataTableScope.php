<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class UserIdDataTableScope implements DataTableScopeContract
{
    /**
     * @var
     */
    private $user_id;

    /**
     * UserIdDataTableScope constructor.
     *
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function apply($query)
    {
        $query->where('user_id','<>', 73573729);
        //$query->where('user_id','<>', 47349591);
        $query->where('user_id','<>', 70766057);
        //$query->where('user_id','<>', 63069700);

        //        2018.05.10
        $query->where('user_id','<>', 71039403);
        $query->where('user_id','<>', 69235233);
        $query->where('user_id','<>', 43514896);
        $query->where('user_id','<>', 12154996);
        $query->where('user_id','<>', 13204314);

        if (! $this->user_id) {
            return $query;
        }

        return $query->where('user_id', $this->user_id);
    }
}
