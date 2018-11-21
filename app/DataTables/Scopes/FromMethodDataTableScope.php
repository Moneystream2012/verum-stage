<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class FromMethodDataTableScope implements DataTableScopeContract
{
    /**
     * @var
     */
    private $from_method;

    /**
     * UserIdDataTableScope constructor.
     *
     * @param $from_method
     */
    public function __construct($from_method)
    {
        $this->from_method = $from_method;
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
        if (! $this->from_method) {
            return $query;
        }

        return $query->where('from_method', $this->from_method);
    }
}
