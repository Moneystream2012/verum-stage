<?php

namespace App\DataTables\Administrator;

use App\Share;
use Yajra\Datatables\Services\DataTable;

class SharesDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $user_id])}}">{{$user_id}}</a>')->editColumn('amount', '{{formatUSD($amount)}} $')->editColumn('price', '{{formatUSD($price)}} $')->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Share::query();

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
            'number_of' => [
                'title'      => 'Количество',
                'searchable' => false,
            ],
            'price' => [
                'title'      => 'Цена',
                'searchable' => false,
            ],
            'method' => [
                'title'      => 'Method',
                'searchable' => false,
            ],

            'is_refund' => [
                'title' => 'Продано',
                // 'name' => 'is_refund',
                'searchable' => false,
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
        return 'administrator\sharesdatatables_'.time();
    }
}
