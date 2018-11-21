<?php

namespace App\DataTables\Administrator;

use App\Verification;
use Yajra\Datatables\Services\DataTable;

class VerificationsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $user_id])}}">{{$user_id}}</a>')->rawColumns(['user_link'])->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Verification::query();

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
            'user_link' => [
                'title' => 'User ID',
                'name'  => 'user_id',
            ],
            'first_name' => [
                'title'      => 'Имя',
            ],
            'last_name' => [
                'title'      => 'Фамилия',
            ],
            'verification_at' => [
                'title'=> 'Дата',
                'searchable' => false,
            ],
            'status_text' => [
                'title' => 'Статус',
                'name' => 'status',
                'searchable' => false,
            ]
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            'order' => [
                [
                    4,
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
        return 'administrator\verificationsdatatables_'.time();
    }
}
