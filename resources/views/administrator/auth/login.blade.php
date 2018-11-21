@extends('unify.layouts.auth')
@section('title', 'Admin Panel')
@section('page')

	<div class="panel-heading clearfix">
		<div class="pull-left">
			<i class="fa fa-lock"></i> Admin Panel
		</div>
	</div>
	<div class="panel-body">
		@include('flash::message')

		<form novalidate="novalidate" role="form" method="POST" accept-charset="UTF-8"
		      action="{{ route('administrator.login.post') }}">
			{{ csrf_field() }}
			<div class="form-group {{ $errors->has('email') || $errors->has('id') ? ' has-error' : '' }}">
				<label for="email">E-Mail Address</label>
				<input type="text" autocomplete="off" autofocus="autofocus" class="form-control" name="email" id="email"
				       placeholder="E-Mail Address">
				@if ($errors->has('email') || $errors->has('id'))
					<span class="help-block">
						<strong style="display: block">{{ $errors->first('email') }}</strong>
						<strong>{{ $errors->first('id') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
				<label for="password">Password </label>
				<input type="password" autocomplete="off" class="form-control" name="password" id="password"
				       placeholder="******">

				@if ($errors->has('password'))
					<span class="help-block">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
				@endif
			</div>
			<div class="form-group" style="margin-bottom: 10px;margin-top: 25px;text-align: center">
				<button type="submit" style="width: 50%" class="btn btn-primary">
					<i class="fa fa-sign-in"></i> Login
				</button>
			</div>
		</form>
	</div>
@endsection

