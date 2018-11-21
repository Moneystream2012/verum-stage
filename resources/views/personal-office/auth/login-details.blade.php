@extends('layouts.auth')
@section('page')
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<i class="fa fa-plus-circle"></i> Login Details
		</div>
		<div class="pull-right">
			<a href="{{ route('personal-office.login') }}">
				<i class="fa fa-lock"></i> Sign in
			</a>
		</div>
	</div>
	<div class="panel-body">
		<div class="alert alert-success alert-dismissible" role="alert">
			<strong>Registration is almost complete!</strong>
			<ol style="margin: 0;padding-left: 13px;">
				<li>Confirm your email: <b>{{ $user->email }}</b></li>
				<li>Save your personal information!</li>
			</ol>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<label for="id">Member ID:</label>
					<input type="text" class="form-control input-lg" id="id" value="{{ $user->id }}" readonly>
				</div>
				<div class="col-xs-6">
					<label for="username">Username:</label>
					<input type="text" class="form-control input-lg" id="username" value="{{ $user->username }}"
						   readonly>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<label for="email">E-Mail:</label>
					<input type="text" class="form-control input-lg" id="email" value="{{ $user->email }}" readonly>
				</div>
				<div class="col-xs-6">
					<label for="mobile-number">Mobile number:</label>
					<input type="text" class="form-control input-lg" id="mobile-number"
						   value="{{ $user->mobile_number }}" readonly>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<label for="password">Password:</label>
					<input type="text" class="form-control input-lg" id="password" value="{{ $user->password }}"
						   readonly>
				</div>
				<div class="col-xs-6">
					<label for="transaction_password">Transaction password:</label>
					<input type="text" class="form-control input-lg" id="transaction_password"
						   value="{{ $user->transaction_password }}" readonly>
				</div>
			</div>
		</div>

		<br>

		<div class="form-group">
			<a href="{{ route('personal-office.login') }}" class="btn btn-block btn-primary">
				<i class="fa fa-sign-in"></i> Login
			</a>
		</div>
	</div>
@endsection
