@extends('layouts.personal-office')
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/js/intlTelInput.min.js"
        integrity="sha256-QCAySImJGNb+zBaYHIvH8T7EnfUe+fcj41t+niXPPAw=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/js/utils.js"
        integrity="sha256-B09aYrCSBLxP05N5uY9P/ZSfIlSAoGyXXWxnMfYNE2E=" crossorigin="anonymous"></script>

<script src="{{asset('veneto/assets/plugins/jquery-select2/select2.min.js')}}"></script>

<script>
	jQuery(function ($) {
		'use strict';
		// Select2
		$('select.form-select2').select2();

		var telInput = $("#mobile_number");
		telInput.intlTelInput({
			preferredCountries: ["ua", "ru"]
		});
		$("form").submit(function () {
			telInput.val(telInput.intlTelInput("getNumber"));
			$('#mobile_code').val(telInput.intlTelInput("getSelectedCountryData").iso2.toUpperCase());
		});
	});

</script>
@endpush
@push('page-styles')
<link rel="stylesheet" href="{{asset('veneto/css/plugins/jquery-select2.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/css/intlTelInput.css"
      integrity="sha256-rbawPSmJ3tfXh54OEfgiHNP9ulKlINEOPcLiVoC1pXI=" crossorigin="anonymous"/>
<style>
	.iti-flag { background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/img/flags.png"); }

	.intl-tel-input { width: 100%; }

	.intl-tel-input .iti-flag .arrow { border: none; }
</style>
@endpush
@section('page')
	<div class="container-fluid-md">
		<form action="{{route('personal-office.sponsored.new_member.post')}}"
		      role="form"
		      method="post">
			{{ csrf_field() }}
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
								<label for="inputFirstName" class="control-label">First Name</label>
								<input type="text" name="first_name" class="form-control" id="inputFirstName"
								       placeholder="First Name"
								       value="{{ old('first_name') }}" autocomplete="off">
								@if ($errors->has('first_name'))
									<span class="help-block">{{ $errors->first('first_name') }}</span>
								@endif
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
								<label for="inputLastName" class="control-label">Last Name</label>
								<input type="text" name="last_name" class="form-control" id="inputLastName" placeholder="Last Name"
								       value="{{ old('last_name') }}" autocomplete="off">
								@if ($errors->has('last_name'))
									<span class="help-block">{{ $errors->first('last_name') }}</span>
								@endif
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
								<label for="username" class="control-label">Username</label>
								<input type="text" name="username" class="form-control"  autocomplete="off" id="username" placeholder="User Name"
								       value="{{ old('username') }}">
								@if ($errors->has('username'))
									<span class="help-block">{{ $errors->first('username') }}</span>
								@endif
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
								<label for="email" class="control-label">Email</label>
								<input type="email" name="email" class="form-control" id="email"  autocomplete="off" placeholder="Email"
								       value="{{ old('email') }}">
								@if ($errors->has('email'))
									<span class="help-block">{{ $errors->first('email') }}</span>
								@endif
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group {{ $errors->has('mobile_number') ? ' has-error' : '' }}">
								<label for="mobile_number" class="control-label">Mobile Number</label>
								<input type="hidden" name="mobile_code" id="mobile_code" value="UA">
								<input type="tel" name="mobile_number" class="form-control"  autocomplete="off" id="mobile_number"
								       value="{{ old('mobile_number') }}">
								@if ($errors->has('mobile_number'))
									<span class="help-block">{{ $errors->first('mobile_number') }}</span>
								@endif
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
								<label for="country" class="control-label">Country</label>
								<select class="form-control form-chosen form-select2" data-placeholder="Choose a Country..."
								        name="country"
								        id="country">
									@foreach ($countries as $key => $val)
										<option value="{{ $key }}"
										        @if (old('country') == $key || (!old('country') && strtoupper(\App::getLocale() == 'uk' ?  'ua' : \App::getLocale()) == $key)) selected @endif>{{ $val }}</option>
									@endforeach
								</select>
								@if ($errors->has('country'))
									<span class="help-block">{{ $errors->first('country') }}</span>
								@endif
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
								<label for="password" class="control-label">Password</label>
								<input type="password" class="form-control" name="password"  autocomplete="off" id="password"
								       placeholder="Password">
								@if ($errors->has('password'))
									<span class="help-block">{{ $errors->first('password') }}</span>
								@endif
							</div>
						</div>
						<div class="col-sm-6">

							<div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
								<label for="password_confirmation" class="control-label">Password Confirmation</label>
								<input type="password" class="form-control" name="password_confirmation"
								       id="password_confirmation"
                                       autocomplete="off"
								       placeholder="Password Confirmation">
								@if ($errors->has('password_confirmation'))
									<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
								@endif
							</div>
						</div>
					</div>

				</div>
				<div class="panel-footer">
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Submit</button>
						<a href="{{route('personal-office.sponsored.binary')}}" class="btn btn-white">My Network</a>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection
