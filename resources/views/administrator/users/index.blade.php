@extends('layouts.administrator')
@section('title', 'Пользователи')

@push('page-styles')
<link rel="stylesheet" href="{{asset('veneto/css/plugins/jquery-dataTables.min.css')}}">
<style>
	.table .table { background-color: #fff; }

	.dataTables_wrapper { position: relative; }

	.dataTables_processing { position: absolute; top: 50%; left: 50%; width: 100%; height: 40px; margin-left: -50%; margin-top: -25px; padding-top: 20px; text-align: center; font-size: 1.2em; background-color: white; background: -webkit-gradient(linear, left top, right top, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, 0.9)), color-stop(75%, rgba(255, 255, 255, 0.9)), color-stop(100%, rgba(255, 255, 255, 0))); background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%); background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%); background: -ms-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%); background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%); background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%) }
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
	$('#dataTableBuilder tbody').on('click', 'td.dt-details-control', function () {
		var tr = $(this).closest('tr');
		var row = window.LaravelDataTables['dataTableBuilder'].row(tr);

		if(row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			// Open this row
			console.log(row.data());
			row.child(template(row.data())).show();
			tr.addClass('shown');
		}
	});
</script>
@endpush

@section('page')

	<div class="container-fluid-md">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Список пользователей</h4>
			</div>
			<div class="panel-body">
				{!! $dataTable->table() !!}
			</div>
		</div>
	</div>

	<script id="details-template" type="text/x-handlebars-template">
		<table class="table no-margin">
			<tr>
				<td>Id:</td>
				<td>@{{{user_link}}}</td>
			</tr>
			<tr>
				<td>Логин:</td>
				<td>@{{username}}</td>
			</tr>
			<tr>
				<td>Имя:</td>
				<td>@{{full_name}}</td>
			</tr>
			<tr>
				<td>Спонсор:</td>
				<td>@{{{sponsor_link}}}</td>
			</tr>
            <tr>
                <td>Plan:</td>
                <td>@{{plan}}</td>
            </tr>
			<tr>
				<td>Email:</td>
				<td>@{{email}}</td>
			</tr>
			<tr>
				<td>USD Balance:</td>
				<td>@{{balance}}</td>
			</tr>
			<tr>
				<td>VMC Balance:</td>
				<td>@{{mining_balance}}</td>
			</tr>
			<tr>
				<td>Мобильный номер:</td>
				<td>@{{mobile_number}}</td>
			</tr>
			<tr>
				<td>TeamDeveloper:</td>
				<td>@{{team_developer}}</td>
			</tr>
			<tr>
				<td>Blocked:</td>
				<td>@{{blocked}}</td>
			</tr>
			<tr>
				<td>Дата регистрация:</td>
				<td>@{{created_at}}</td>
			</tr>
			<tr>
				<td>Дата авторизации:</td>
				<td>@{{#if last_login_at}} @{{last_login_at}} @{{else}} - @{{/if}}</td>
			</tr>
			<tr>
				<td>Дата обновления:</td>
				<td>@{{#if updated_at}} @{{updated_at}} @{{else}} - @{{/if}}</td>
			</tr>
		</table>
	</script>

@endsection

