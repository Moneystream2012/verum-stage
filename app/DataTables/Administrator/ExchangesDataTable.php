<?php

namespace App\DataTables\Administrator;

use App\Exchange;
use Yajra\Datatables\Services\DataTable;

class ExchangesDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $user_id])}}">{{$user_id}}</a>')->rawColumns(['user_link'])->editColumn('amount', '{{formatUSD($amount)}} USD')->addColumn('exchange', '{{$from_method}} => {{$to_method}} ')->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Exchange::query();
        $query->where('user_id','<>', 71039403);
        $query->where('user_id','<>', 69235233);
        $query->where('user_id','<>', 43514896);
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()->columns($this->getColumns())->ajax('')->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => [
                'title' => '#',
            ],
            'user_link' => [
                'title' => 'User ID',
                'name'  => 'user_id',
            ],
            'amount' => [
                'title'      => 'Сумма',
                'searchable' => false,
            ],
            'exchange' => [
                'title'      => 'Обмен',
                'searchable' => false,
                'orderable'  => false,
            ],
            'created_at' => [
                'searchable' => false,
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'administrator\exchangesdatatables_'.time();
    }
}
