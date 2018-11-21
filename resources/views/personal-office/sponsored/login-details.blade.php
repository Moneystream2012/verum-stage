@extends('layouts.personal-office')

@section('page')
	<div class="container-fluid-md">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="form-group">
					<div class="row">
						<div class="col-xs-6">
							<label for="id">Member ID:</label>
							<input type="text" class="form-control" id="id" value="{{ $user->id }}" readonly>
						</div>
						<div class="col-xs-6">
							<label for="username">Username:</label>
							<input type="text" class="form-control" id="username" value="{{ $user->username }}"
							       readonly>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-xs-6">
							<label for="email">E-Mail:</label>
							<input type="text" class="form-control" id="email" value="{{ $user->email }}" readonly>
						</div>
						<div class="col-xs-6">
							<label for="mobile-number">Mobile number:</label>
							<input type="text" class="form-control" id="mobile-number"
							       value="{{ $user->mobile_number }}" readonly>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-xs-6">
							<label for="password">Password:</label>
							<input type="text" class="form-control" id="password" value="{{ $user->password }}"
							       readonly>
						</div>
						<div class="col-xs-6">
							<label for="transaction_password">Transaction password:</label>
							<input type="text" class="form-control" id="transaction_password"
							       value="{{ $user->transaction_password }}" readonly>
						</div>
					</div>
				</div>


			</div>
			<div class="panel-footer margin-lg-top hidden">
				<a href="" class="btn btn-round btn-default btn-sm">Back</a>
			</div>
		</div>

	</div>

@endsection