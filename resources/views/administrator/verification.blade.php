@extends('layouts.administrator')
@section('title', 'Верификация')

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

            $.fn.verified = function (id, btn, verified) {
                $(btn).button('loading');
                $.ajax({
                    type: 'GET',
                    url: '/administrator/o38oRuD745/verifications/verified/' + id + '/' + verified,
                    dataType: 'json',
                    success: function (data) {
                        alert(data.msg);
                        dataTables.ajax.reload();
                        $(btn).button('reset');
                    },
                    error: function () {
                        alert('Error!');
                        $(btn).button('reset')
                    }
                });
            };
        });
    </script>
@endpush

@section('page')

    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-heading text-right">
                <div class="btn-group ">
                    <a href="{{route('administrator.verifications.index', ['status' => \App\Verification::PROCESSING])}}" class="btn btn-link">ALL</a>
                    <a href="{{route('administrator.verifications.index', ['status' => \App\Verification::PROCESSING])}}" class="btn btn-link">PROCESSING</a>
                    <a href="{{route('administrator.verifications.index', ['status' => \App\Verification::VERIFIED])}}" class="btn btn-link">VERIFIED</a>
                </div>
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
                <td>Имя:</td>
                <td>@{{{first_name}}}</td>
            </tr>
            <tr>
                <td>Фамилия:</td>
                <td>@{{{last_name}}}</td>
            </tr>
            <tr>
                <td>Страна:</td>
                <td>@{{{country_name}}}</td>
            </tr>
            <tr>
                <td>Мобильный номер:</td>
                <td>@{{{mobile_number_format}}}</td>
            </tr>
            <tr>
                <td>E-Mail:</td>
                <td>@{{{email}}}</td>
            </tr>
            <tr>
                <td>Аватар:</td>
                <td><img src="@{{{avatar_url}}}" alt="@{{{first_name}}}"></td>
            </tr>
            <tr>
                <td>Документ:</td>
                <td><img src="@{{{doc_img_url}}}" alt="@{{{first_name}}}"></td>
            </tr>
            <tr>
                <td>Статус:</td>
                <td>@{{status_text}}</td>
            </tr>
            <tr>
                <td>Дата:</td>
                <td>@{{#if verification_at}} @{{verification_at}} @{{else}} - @{{/if}}</td>
            </tr>
            @{{#if status_processing}}
            <tr>
                <td>Действия:</td>
                <td>
                    <button type="button" onclick="$().verified(@{{user_id}}, this, 1)" data-loading-text="Loading..."
                            class="btn btn-success" autocomplete="off">
                        Верифицировать
                    </button>
                    |
                    <button type="button" onclick="$().verified(@{{user_id}}, this, 0)" data-loading-text="Loading..."
                            class="btn btn-danger"
                            autocomplete="off">
                        Отклонить
                    </button>
                </td>
            </tr>
            @{{/if}}
        </table>
    </script>

@endsection

