<?php

namespace App\DataTables\Administrator;

use App\InitialCoinOffering;
use Yajra\Datatables\Services\DataTable;

class InitialCoinOfferingsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'user_id\' => $user_id])}}">{{$user_id}}</a>')
            ->rawColumns([
            'user_link'
            ])->editColumn('amount', '{{formatUSD($amount)}}')->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = InitialCoinOffering::query();

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
            'ico_type'     => [
                'title'      => 'ICO Type',
                'searchable' => false,
            ],
            'amount'     => [
                'title'      => 'Amount USD',
                'searchable' => false,
            ],
            'method' => [
                'title'      => 'Payment Method',
                'searchable' => false,
            ],
            'created_at'    => [
                'title'      => 'Date',
                'searchable' => false,
            ],
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            'order' => [
                [
                    0,
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
        return 'administrator\initialcoinofferingssdatatables_'.time();
    }
}
