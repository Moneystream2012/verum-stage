<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class QueryWhereDataTableScope implements DataTableScopeContract
{
    /**
     * @var
     */
    private $column;
    /**
     * @var null
     */
    private $operator;
    /**
     * @var null
     */
    private $value;

    /**
     * UserIdDataTableScope constructor.
     * @param $column
     * @param null $operator
     * @param null $value
     */
    public function __construct($column, $operator = null, $value = null)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
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
        if (!$this->value) {
            return $query;
        }

        return $query->where($this->column, $this->operator, $this->value);
    }
}
