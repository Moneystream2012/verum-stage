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
		<div class="row">
			<div class="col-md-5">
				<div class="panel panel-default panel-profile-details">
					<div class="panel-body">
						<div class="col-sm-5 text-center">
							<img alt="image" class="img-circle img-profile  margin-md-top" src="{{ $auth->avatar_url }}">
						</div>
						<div class="col-sm-7 profile-details">
							<h3>{{$auth->full_name}}</h3>

							<dl class="margin-sm-bottom">
								<dt>Created at</dt>
								<dd>{{$auth->created_at}}</dd>
							</dl>
							<dl class="margin-sm-bottom">
								<dt>Updated at</dt>
								<dd>{{$auth->updated_at ?? '-'}}</dd>
							</dl>
							<dl class="margin-sm-bottom">
								<dt>Last login at</dt>
								<dd>{{$auth->last_login_at}}</dd>
							</dl>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-xs-6">
							<dl>
								<dt>Member id</dt>
								<dd>{{$auth->id}}</dd>
							</dl>
							<dl class="margin-sm-bottom">
								<dt>Username</dt>
								<dd>{{$auth->username}}</dd>
							</dl>
						</div>
						<div class="col-xs-6">
							<dl>
								<dt>Email</dt>
								<dd>{{$auth->email}}</dd>
							</dl>
							<dl class="margin-sm-bottom">
								<dt>Sponsor</dt>
								<dd>{{$auth->sponsor()->value('username') ?? '-'}}</dd>
							</dl>
						</div>
					</div>
					{{--<div class="panel-heading hidden">
						<p class="panel-title">Авторизация через социальные сети</p>
					</div>
					<div class="panel-body hidden">
						@if(isset($social_account['vkontakte']))
							<div class="btn-group margin-sm-horizontal margin-sm-vertical">
								<a href="{{route('personal-office.profile.remove_social_account','vkontakte')}}"
								   class="btn btn-primary"><i class="fa fa-trash"></i></a>
								<a class="btn btn-default" disabled="">id{{$social_account['vkontakte']}} <i class="fa fa-vk"></i></a>
							</div>
						@else
							<a href="{{route('personal-office.login.social', 'vkontakte')}}"
							   class="btn btn-default margin-sm-horizontal margin-sm-vertical">
								Связать <i class="fa fa-vk"></i>
							</a>
						@endif

						@if(isset($social_account['facebook']))
							<div class="btn-group margin-sm-horizontal margin-sm-vertical">
								<a href="{{route('personal-office.profile.remove_social_account','facebook')}}"
								   class="btn btn-primary"><i class="fa fa-trash"></i></a>
								<a class="btn btn-default" disabled="">ID {{$social_account['facebook']}}
									<i class="fa fa-facebook-f"></i></a>
							</div>
						@else
							<a href="{{route('personal-office.login.social', 'facebook')}}"
							   class="btn btn-default margin-sm-horizontal margin-sm-vertical">Связать <i
										class="fa fa-facebook-f"></i></a>
						@endif

						@if(isset($social_account['instagram']))
							<div class="btn-group margin-sm-horizontal margin-sm-vertical">
								<a href="{{route('personal-office.profile.remove_social_account','instagram')}}"
								   class="btn btn-primary"><i class="fa fa-trash"></i></a>
								<a class="btn btn-default" disabled="">ID{{$social_account['instagram']}} <i
											class="fa fa-instagram"></i></a>
							</div>
						@else
							<a href="{{route('personal-office.login.social', 'instagram')}}"
							   class="btn btn-default margin-sm-horizontal margin-sm-vertical">Связать <i
										class="fa fa-instagram"></i></a>
						@endif
						@if(isset($social_account['twitter']))
							<div class="btn-group margin-sm-horizontal margin-sm-vertical">
								<a href="{{route('personal-office.profile.remove_social_account','twitter')}}"
								   class="btn btn-primary"><i class="fa fa-trash"></i></a>
								<a class="btn btn-primary" disabled="">ID{{$social_account['twitter']}} <i
											class="fa fa-twitter"></i></a>
							</div>
						@else
							<a href="{{route('personal-office.login.social', 'twitter')}}"
							   class="btn btn-default margin-sm-horizontal margin-sm-vertical">Связать <i
										class="fa fa-twitter"></i></a>
						@endif
					</div>--}}
				</div>
			</div>

			<div class="col-md-7">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">User data</h4>
					</div>
					<div class="panel-body">
						<form role="form" action="{{route('personal-office.profile.update')}}" method="post"
						      enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
								<label for="inputFirstName" class="control-label">First Name</label>
								<input type="text" name="first_name" class="form-control" id="inputFirstName"
								       placeholder="First Name" value="{{old('first_name') ?? $auth->first_name}}"  autocomplete="off">
								@if ($errors->has('first_name'))
									<span class="help-block">{{ $errors->first('first_name') }}</span>
								@endif
							</div>
							<div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
								<label for="inputLastName" class="control-label">Last Name</label>
								<input type="text" name="last_name" class="form-control" id="inputLastName" placeholder="Last Name"
								       value="{{old('last_name') ?? $auth->last_name}}"  autocomplete="off">
								@if ($errors->has('last_name'))
									<span class="help-block">{{ $errors->first('last_name') }}</span>
								@endif
							</div>

							<div class="form-group hidden {{ $errors->has('email') ? ' has-error' : '' }}">
								<label for="email" class="control-label">Email</label>
								<input type="email" name="email" class="form-control" id="email" placeholder="Email"
								       value="{{old('email') ?? $auth->email}}"  autocomplete="off">
								@if ($errors->has('email'))
									<span class="help-block">{{ $errors->first('email') }}</span>
								@endif
							</div>

							<div class="form-group {{ $errors->has('mobile_number') ? ' has-error' : '' }}">
								<label for="mobile_number" class="control-label">Mobile Number</label>
								<input type="hidden" name="mobile_code" id="mobile_code" value="UA">
								<input type="tel" name="mobile_number" class="form-control" id="mobile_number"
								       value="{{old('mobile_number') ?? $auth->mobile_number }}"  autocomplete="off">
								@if ($errors->has('mobile_number'))
									<span class="help-block">{{ $errors->first('mobile_number') }}</span>
								@endif
							</div>

							<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
								<label for="country" class="control-label">Country</label>
								<select class="form-control form-chosen form-select2" data-placeholder="Choose a Country..."
								        name="country">
									@foreach ($countries as $key => $val)
										<option value="{{ $key }}" {{ $key == $auth->country ? 'selected' : ''}}>{{ $val }}</option>
									@endforeach
								</select>
								@if ($errors->has('country'))
									<span class="help-block">{{ $errors->first('country') }}</span>
								@endif
							</div>
							<div class=" hidden form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
								<label for="inputAvatar" class="control-label">Avatar</label>
								<input type="file" class="form-control" name="avatar" id="inputAvatar"
								       accept="image/jpeg,image/png,image/jpg">
								@if ($errors->has('country'))
									<span class="help-block">{{ $errors->first('avatar') }}</span>
								@endif
								<span class="help-block">Allowed file type extensions are: jpeg, jpg, png. Max size 2 MB</span>
							</div>

							<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
								<label for="inputPassword" class="control-label">Your password</label>
								<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password"  autocomplete="off" required>
								@if ($errors->has('password'))
									<span class="help-block">{{ $errors->first('password') }}</span>
								@endif
							</div>

							<button class="btn btn-primary" type="submit">Update</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
