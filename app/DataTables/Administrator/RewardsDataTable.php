<?php

namespace App\DataTables\Administrator;

use App\History;
use Yajra\Datatables\Services\DataTable;

class RewardsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())->addColumn('user_link', '<a href="{{route(\'administrator.users.show\', [\'id\' => $user_id])}}">{{$user_id}}</a>')->editColumn('title', '{{$title}}')->editColumn('data.amount', '{{formatUSD($data[\'data\'][\'amount\'])}} $')->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = History::where('category', 3)->select(['*']);

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
            'title' => [
                'title'     => 'Выплата за',
                'orderable' => false,
                'name'      => 'type',
            ],
            'data.amount' => [
                'title'      => 'Сумма',
                'searchable' => false,
                'orderable'  => false,
            ],
            'created_at' => [
                'searchable' => false,
            ],
        ];
    }

    protected function getBuilderParameters()
    {
        $html = '<option selected hidden >Сортировка</option>';
        collect(trans('histories.profits'))->each(function ($item, $key) use (&$html) {
            $html .= "<option value=\"$key\">{$item['title']}</option>";
        });

        return [
            'order' => [
                [
                    4,
                    'desc',
                ],
            ],
            'initComplete' => "function () {
            var column = this.api().column( 2 );
            
            var select = $('<select />')
			        .appendTo(column.footer())
			        .on( 'change', function () {
			            column.search( $(this).val()).draw();
			        } )
			        .append( $('".$html."') );
          }",
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'administrator\rewardsdatatables_'.time();
    }
}
