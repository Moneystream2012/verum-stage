<?php

namespace App\DataTables\Administrator;

use App\Replenishment;
use Yajra\Datatables\Services\DataTable;

class ReplenishmentsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'user_id\' => $user_id])}}">{{$user_id}}</a>')->rawColumns([
            'user_link',
            'id',
        ])->editColumn('id', '<a href="{{$payment_url}}" target="_blank">{{$id}}</a>')->editColumn('amount', '{{$amount}}')->editColumn('cost_amount', '{{$cost_amount}}')->addColumn('replenishment', '{{$method}} => {{$to}} ')->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Replenishment::query();
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
            'id'            => [
                'title' => '#',
            ],
            'user_link'     => [
                'title'     => 'User ID',
                'name'      => 'user_id',
                'orderable' => false,
            ],
            'amount'     => [
                'title'      => 'Amount',
                'searchable' => false,
            ],
            'currency'     => [
                'title'      => 'Currency',
                'searchable' => false,
            ],
            'cost_amount'   => [
                'title'      => 'Комиссия',
                'searchable' => false,
            ],
            'replenishment' => [
                'title'      => 'Пополнения',
                'name'       => 'method',
            ],
            'status',
            'created_at'    => [
                'searchable' => false,
            ],
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            'order' => [
                [
                    7,
                    'desc',
                ],
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
        return 'administrator\replenishmentsdatatables_'.time();
    }
}
