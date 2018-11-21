@extends('layouts.personal-office')
@section('page')
	<div class="container-fluid-md">
		<div class="panel panel-default">
			<div class="panel-heading">

			</div>
			<div class="panel-body form-horizontal">

				<div class="form-group">
					<label for="inputPackage" class="col-sm-4 control-label">Package Name</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="inputPackage" value="Activation Package" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPrice" class="col-sm-4 control-label">Price</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="inputPrice" value="44 USD" disabled>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4 col-sm-offset-4">
						@include('include.payment.btn',['service'=> 'active_member'])
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection
