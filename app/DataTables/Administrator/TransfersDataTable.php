<?php

namespace App\DataTables\Administrator;

use App\Transfer;
use Yajra\Datatables\Services\DataTable;

class TransfersDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $user_id])}}">{{$user_id}}</a>')->addColumn('user_link-to', '<a href="{{route(\'administrator.users.show\', [\'id\' => $to_id])}}">{{$to_id}}</a>')->rawColumns(['user_link', 'user_link-to'])->editColumn('amount', '{{formatUSD($amount)}} $')->editColumn('cost_amount', '{{formatUSD($cost_amount)}} $')->addColumn('transfer', '{{$from_username}} => {{$to_username}} ')->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Transfer::query();
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
                'title' => 'Отправитель',
                'name'  => 'user_id',
            ],
            'user_link-to' => [
                'title' => 'Получатель',
                'name'  => 'to_id',
            ],
            'amount' => [
                'title'      => 'Сумма',
                'searchable' => false,
            ],
            'cost_amount' => [
                'title'      => 'Комиссия',
                'searchable' => false,
            ],
            'transfer' => [
                'title'      => 'Перевод',
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
        return 'administrator\transfersdatatables_'.time();
    }
}
