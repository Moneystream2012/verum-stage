@extends('unify.layouts.auth')
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

	<div class="panel-heading clearfix">
		<div class="pull-left">
			<i class="fa fa-plus-circle"></i> Sign up
		</div>
		<div class="pull-right">
			<a href="{{ route('personal-office.login') }}">
				<i class="fa fa-lock"></i> Sign in
			</a>
		</div>
	</div>
	<div class="panel-body">
		<form novalidate="novalidate" role="form" method="POST" accept-charset="UTF-8"
			  action="{{ route('personal-office.register.post') }}">
			{{ csrf_field() }}

			<div class="form-group {{ $errors->has('first_name') || $errors->has('last_name')  ? ' has-error' : '' }}">
				<label for="first_name">Name <span class="text-danger"> *</span></label>
				<div class="row">
					<div class="col-xs-6">
						<input type="text" class="form-control" name="first_name" id="first_name"
							   value="{{ old('first_name') }}"
                               autocomplete="off"
							   placeholder="First Name">
					</div>
					<div class="col-xs-6">
						<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"
							   placeholder="Last Name"  autocomplete="off">
					</div>
				</div>
				@if ($errors->has('first_name') || $errors->has('last_name'))
					<span class="help-block">
                                <strong style="display: block">{{ $errors->first('first_name') }}</strong>
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
				<label for="username">Username <span class="text-danger"> *</span></label>
				<input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}"
					   placeholder="User Name"  autocomplete="off">
				@if ($errors->has('username'))
					<span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email">E-mail <span class="text-danger"> *</span></label>
				<input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}"
					   placeholder="E-mail Address"  autocomplete="off">
				@if ($errors->has('email'))
					<span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('mobile_number') ? ' has-error' : '' }}">
				<label for="mobile_number" class="control-label">Mobile Number</label>
				<input type="hidden" name="mobile_code" id="mobile_code" value="UA">
				<input type="tel" name="mobile_number" class="form-control" id="mobile_number"
				       value="{{ old('mobile_number') }}"  autocomplete="off">
				@if ($errors->has('mobile_number'))
					<span class="help-block">{{ $errors->first('mobile_number') }}</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('sponsor') ? ' has-error' : '' }}">
				<label for="sponsor">Sponsor <span class="text-danger"> *</span></label>
				<input type="text" class="form-control" id="sponsor" name="sponsor"
					   @if(old('sponsor')) value="{{ old('sponsor') }}" @else value="{{$sponsor}}"
					   @endif placeholder="Sponsor Name"  autocomplete="off">
				@if ($errors->has('sponsor'))
					<span class="help-block">
                        <strong>{{ $errors->first('sponsor') }}</strong>
                    </span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('password') || $errors->has('password_confirmation') ? ' has-error' : '' }}">
				<label for="password">Password <span class="text-danger"> *</span></label>
				<div class="row">
					<div class="col-xs-6">
						<input type="password" class="form-control" name="password" id="password"
							   placeholder="Password"  autocomplete="off">
					</div>
					<div class="col-xs-6">
						<input type="password" class="form-control" name="password_confirmation"
							   placeholder="Confirm Password"  autocomplete="off">
					</div>
				</div>
				@if ($errors->has('password') || $errors->has('password_confirmation'))
					<span class="help-block">
                                <strong style="display: block">{{ $errors->first('password') }}</strong>
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
				@endif
			</div>

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

			<div class="panel panel-default hidden">
				<div class="panel-heading">
					<i class="fa fa-legal"></i>
					Terms and conditions
				</div>
				<div class="panel-body">
					<div style="position: relative; overflow: auto; width: auto; height: 150px; text-align: justify">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet autem exercitationem ipsa
							laudantium minus perspiciatis provident quis quo rerum. A accusantium aspernatur dolor eum
							maiores minus soluta suscipit tempora tempore!</p>

					</div>
				</div>
			</div>

			<div class="form-group  {{ $errors->has('terms') ? ' has-error' : '' }}">
				<div class="checkbox">
					<label><input type="checkbox" name="terms"> I agree <a href="#terms" data-toggle="modal" data-target="#terms">terms and conditions</a></label>
				</div>
				@if ($errors->has('terms'))
					<span class="help-block">
                                <strong>{{ $errors->first('terms') }}</strong>
                            </span>
				@endif
			</div>

			<div class="form-group  {{ $errors->has('18_years') ? ' has-error' : '' }}">
				<div class="checkbox">
					<label><input type="checkbox" name="18_years"> I am 18 years of age or older</label>
				</div>
				@if ($errors->has('18_years'))
					<span class="help-block">
                                <strong>{{ $errors->first('18_years') }}</strong>
                            </span>
				@endif
			</div>
			{{--<div class="form-group  {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
				{!! Recaptcha::render(['lang'=> App::getLocale()])  !!}
				@if ($errors->has('g-recaptcha-response'))
					<span class="help-block">
						<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
					</span>
				@endif
			</div>--}}

			<hr>
			<div class="form-group">
				<button type="submit" class="btn btn-block btn-primary">
					<i class="fa fa-save"></i> Create member
				</button>
			</div>
            {{--@captcha(App::getLocale())--}}
		</form>
	</div>

    <div id="terms" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                   @include('terms_en')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
