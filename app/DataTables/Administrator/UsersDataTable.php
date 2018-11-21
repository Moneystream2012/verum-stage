<?php

namespace App\DataTables\Administrator;

use App\User;
use Yajra\Datatables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $id])}}">{{$id}}</a>')->addColumn('sponsor_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $sponsor_id])}}">{{$sponsor_id}}</a>')->editColumn('balance', '{{formatUSD($balance)}} $')->editColumn('mining_balance', '{{formatUSD(VMCtoUSD($mining_balance))}} $')->rawColumns(['user_link', 'sponsor_link'])->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = User::query();
        $query->where('id','<>', 73573729);
        //$query->where('id','<>', 47349591);
        $query->where('id','<>', 70766057);
//        2018.05.10
        $query->where('id','<>', 71039403);
        $query->where('id','<>', 69235233);
        $query->where('id','<>', 43514896);
        //$query->where('id','<>', 63069700);
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
                'name'  => 'id',
            ],
            'username' => [
                'title' => 'Login',
            ],
            'full_name' => [
                'title'      => 'Имя',
                'searchable' => false,
                'orderable'  => false,
            ],
            'balance' => [
                'searchable' => false,
            ],
            'mining_balance' => [
                'searchable' => false,
            ],
            'plan' => [
                'title'      => 'Plan',
                'searchable' => false,
            ],
            'created_at' => [
                'title'      => 'Регистрация',
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
        return 'usersdatatables_'.time();
    }
}
