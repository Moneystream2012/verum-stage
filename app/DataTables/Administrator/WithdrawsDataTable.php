<?php

namespace App\DataTables\Administrator;

use App\Withdraw;
use Yajra\Datatables\Services\DataTable;

class WithdrawsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $user_id])}}">{{$user_id}}</a>')->rawColumns(['user_link'])->editColumn('amount', '{{formatUSD($amount)}} $')->editColumn('cost_amount', '{{formatUSD($cost_amount)}} $')->addColumn('withdraw', '{{$from_method}} => {{$to_method}} ')->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Withdraw::with('user')->select('withdraws.*');

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
            [
                'className'  => 'dt-details-control',
                'orderable'  => false,
                'searchable' => false,
                'data'       => null,
                'title'      => '',

                'defaultContent' => '<i class="fa fa-fw dt-details-toggle"></i>',
            ],
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
            'cost_amount' => [
                'title'      => 'Комиссия',
                'searchable' => false,
            ],
            'withdraw' => [
                'title'      => 'Вывод',
                'searchable' => false,
                'orderable'  => false,
            ],
            'status_text' => [
                'title'      => 'Статус',
                'name'       => 'status',
                'searchable' => false,
            ],
            'done_at' => [
                'defaultContent' => '-',
                'searchable'     => false,
            ],
            'created_at' => [
                'searchable' => false,
            ],
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            'order' => [
                [
                    6,
                    'asc',
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
        return 'administrator\withdrawsdatatables_'.time();
    }
}
