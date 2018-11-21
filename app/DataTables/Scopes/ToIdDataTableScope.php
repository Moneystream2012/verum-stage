<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class ToIdDataTableScope implements DataTableScopeContract
{
    /**
     * @var
     */
    private $to_id;

    /**
     * UserIdDataTableScope constructor.
     *
     * @param $to_id
     */
    public function __construct($to_id)
    {
        $this->to_id = $to_id;
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
        if (! $this->to_id) {
            return $query;
        }

        return $query->where('to_id', $this->to_id);
    }
}
