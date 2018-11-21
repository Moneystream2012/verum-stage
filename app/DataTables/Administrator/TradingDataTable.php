<?php

namespace App\DataTables\Administrator;

use App\Trading;
use Yajra\Datatables\Services\DataTable;

class TradingDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())
            ->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $user_id])}}">{{$user_id}}</a>')
            ->addColumn('closed', '@if($status < 3 ) <a href="{{route(\'administrator.trading.closed\', [\'id\' => $id])}}" class="btn btn-danger">Закрыть</a> @else - @endif')
            ->rawColumns(['user_link', 'closed'])
            ->editColumn('invest', '{{formatUSD($invest)}} $')
            ->editColumn('profit', '{{formatUSD($profit)}} $')
            ->editColumn('payout', '{{formatUSD($payout)}} $')
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Trading::query();
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
            'invest' => [
                'title'      => 'Invest',
                'name'  => 'invest',
                'searchable' => false,
            ],
            'profit' => [
                'searchable' => false,
            ],
            'payout' => [
                'searchable' => false,
            ],
            'number_of_payout' => [
                'title'      => 'Выплат',
                'name'  => 'number_of',
                'searchable' => false,
            ],
            'status_text' => [
                'title' => 'Status',
                'name' => 'status',
                'searchable' => false,
            ],
            'calculate_at' => [
                'searchable'     => false,
            ],
            'created_at' => [
                'searchable' => false,
            ],
            'closed' => [
                'title' => 'Edit',
                'searchable' => false,
            ],
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            'order' => [
                [
                    1,
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
        return 'administrator\tradingdatatables_'.time();
    }
}
