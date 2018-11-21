@extends('layouts.administrator')
@section('title', 'Вывод')

@push('page-styles')
<link rel="stylesheet" href="{{asset('veneto/css/plugins/jquery-dataTables.min.css')}}">
<style>
    .table .table {
        background-color: #fff;
    }

    .dataTables_wrapper {
        position: relative;
    }

    .dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 40px;
        margin-left: -50%;
        margin-top: -25px;
        padding-top: 20px;
        text-align: center;
        font-size: 1.2em;
        background-color: white;
        background: -webkit-gradient(linear, left top, right top, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, 0.9)), color-stop(75%, rgba(255, 255, 255, 0.9)), color-stop(100%, rgba(255, 255, 255, 0)));
        background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
        background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
        background: -ms-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
        background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
        background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%)
    }
</style>

@endpush

@push('page-scripts')

<script src="{{asset('veneto/assets/plugins/jquery-datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('veneto/assets/plugins/jquery-datatables/js/dataTables.tableTools.js')}}"></script>
<script src="{{asset('veneto/assets/plugins/jquery-datatables/js/dataTables.bootstrap.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.min.js"></script>
{!! $dataTable->scripts() !!}

<script>
    var template = Handlebars.compile($("#details-template").html());
    $('#dataTableBuilder').addClass('table-striped');
    var dataTables = window.LaravelDataTables['dataTableBuilder'];
    $('#dataTableBuilder tbody').on('click', 'td.dt-details-control', function () {
        var tr = $(this).closest('tr');
        var row = dataTables.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            console.log(row.data());
            row.child(template(row.data())).show();
            tr.addClass('shown');
        }

        $.fn.payout = function (id, e) {
            console.log(id);
            var tx = $('#tx_' + id).val();
            if (!tx.length) {
                alert('Txid транзакции НЕ УКАЗАН!');
                return;
            }
            ajax($(e).button('loading'), 'payout/' + id + '/' + tx);
        };

        $.fn.rejection = function (id, e) {
            ajax($(e).button('loading'), 'rejection/' + id);
        };

        function ajax(btn, param) {
            $.ajax({
                type: 'GET',
                url: '/administrator/o38oRuD745/withdraws/' + param,
                dataType: 'json',
                success: function (data) {
                    alert(data.msg);
                    dataTables.ajax.reload();
                    btn.button('reset')
                },
                error: function (data) {
                    console.log('Error:', data);
                    alert('Error!');
                    btn.button('reset')
                }
            });
        }

    });
</script>
@endpush

@section('page')

    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Список выводов</h4>
            </div>
            <div class="panel-body">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>

    <script id="details-template" type="text/x-handlebars-template">
        <table class="table no-margin">
            <tr>
                <td>User ID:</td>
                <td>@{{{user_link}}}</td>
            </tr>
            <tr>
                <td>Login:</td>
                <td>@{{{user.username}}}</td>
            </tr>
            <tr>
                <td>Сумма:</td>
                <td>@{{ amount }}</td>
            </tr>
            <tr>
                <td>Вывод:</td>
                <td>@{{ from_method }} => @{{ to_method }}</td>
            </tr>
            <tr>
                <td>Платежный счет:</td>
                <td>@{{ wallet_address }}</td>
            </tr>
            <tr>
                <td>Статус:</td>
                <td>@{{status_text}}</td>
            </tr>
            <tr>
                <td>Дата заявки:</td>
                <td>@{{created_at}}</td>
            </tr>
            <tr>
                <td>Дата выполнения:</td>
                <td>@{{#if done_at}} @{{done_at}} @{{else}} - @{{/if}}</td>
            </tr>
            <tr>
                <td>Txid транзакции:</td>
                <td>
                    @{{#unless status}}
                    <input type="text" id="tx_@{{id}}" style="width: 100%" class="form-control"/>
                    @{{/unless}}

                    @{{#if status}}
                    <a href="@{{link_tx}}" target="_blank">@{{tx}}</a>
                    @{{/if}}
                </td>
            </tr>

            @{{#unless status}}
            <tr>
                <td>Действия:</td>
                <td>
                    <button type="button" onclick="$().payout(@{{id}}, this)" data-loading-text="Loading..."
                            class="btn btn-success" autocomplete="off">
                        Принять
                    </button>
                    |
                    <button type="button" onclick="$().rejection(@{{id}}, this)" data-loading-text="Loading..."
                            class="btn btn-danger"
                            autocomplete="off">
                        Отклонить
                    </button>
                </td>
            </tr>
            @{{/unless}}
        </table>
    </script>

@endsection

