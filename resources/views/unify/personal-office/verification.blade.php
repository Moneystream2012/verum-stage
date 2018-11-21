@extends('unify.layouts.personal-office')
@push('page-scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/js/intlTelInput.min.js"
            integrity="sha256-QCAySImJGNb+zBaYHIvH8T7EnfUe+fcj41t+niXPPAw=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/js/utils.js"
            integrity="sha256-B09aYrCSBLxP05N5uY9P/ZSfIlSAoGyXXWxnMfYNE2E=" crossorigin="anonymous"></script>

    <script>
        jQuery(function ($) {
            'use strict';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/css/intlTelInput.css"
          integrity="sha256-rbawPSmJ3tfXh54OEfgiHNP9ulKlINEOPcLiVoC1pXI=" crossorigin="anonymous"/>

    <style>
        .iti-flag {
            background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/img/flags.png");
        }

        .intl-tel-input {
            width: 100%;
        }

        .intl-tel-input .iti-flag .arrow {
            border: none;
        }
    </style>
@endpush
@section('main-content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="row gutters ">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body text-center">
                    <div class="user-profile m-0">
                        <img src="{{ $auth->avatar_url }}" class="profile-thumb" alt="{{$auth->full_name}}">
                        <h6 class="profile-name mb-0">{{$auth->full_name}}</h6>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Member id: {{$auth->id}}</li>
                    <li class="list-group-item">Username: {{$auth->username}}</li>
                    <li class="list-group-item">Email: {{$auth->email}}</li>
                    <li class="list-group-item">Sponsor: {{$auth->sponsor_username}}</li>
                    <li class="list-group-item">Country: {{$auth->country_name}}</li>
                    <li class="list-group-item">Mobile Number: {{$auth->mobile_number_format}}</li>
                    <li class="list-group-item">Status: <strong class="text-{{$auth->verified ? 'secondary' : 'warning'}}">{{$verification->status_text}}</strong></li>
                    <li class="list-group-item">Date of verification: @format_date($verification->verification_at)</li>
                </ul>
            </div>

        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header text-center">Edit Profile</div>
                <div class="card-body">
                    <form role="form" action="{{route('personal-office.verification.update')}}" method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="inputFirstName" class="control-label">First Name</label>
                            <input type="text" name="first_name"
                                   class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                   id="inputFirstName"
                                   placeholder="First Name" value="{{old('first_name') ?? $verification->first_name}}"
                                   autocomplete="off"
                                   required
                                   @input_disabled($verification->status_processing)>
                            @if ($errors->has('first_name'))
                                <span class="form-text text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputLastName" class="control-label">Last Name</label>
                            <input type="text" name="last_name"
                                   class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                   id="inputLastName"
                                   placeholder="Last Name"
                                   value="{{old('last_name') ?? $verification->last_name}}"
                                   autocomplete="off"
                                   required
                                   @input_disabled($verification->status_processing)>
                            @if ($errors->has('last_name'))
                                <span class="form-text text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="mobile_number" class="control-label">Mobile Number</label>
                            <input type="hidden" name="mobile_code" id="mobile_code" value="UA">
                            <input type="tel" name="mobile_number"
                                   class="form-control {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}"
                                   id="mobile_number"
                                   value="{{old('mobile_number') ?? $verification->mobile_number }}"
                                   autocomplete="off"
                                   required
                                   @input_disabled($verification->status_processing)>
                            @if ($errors->has('mobile_number'))
                                <span class="form-text text-danger">{{ $errors->first('mobile_number') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input type="text" name="email"
                                   class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   id="email"
                                   placeholder="Email"
                                   value="{{old('email') ?? $verification->email}}"
                                   autocomplete="off"
                                   required
                                   @input_disabled($verification->status_processing)>
                            @if ($errors->has('email'))
                                <span class="form-text text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="country" class="control-label">Country</label>
                            <select
                                class="form-control form-chosen form-select2 {{ $errors->has('country') ? ' is-invalid' : '' }}" data-placeholder="Choose a Country..."
                                name="country"
                                required
                                @input_disabled($verification->status_processing)>
                                @foreach ($countries as $key => $val)
                                    <option
                                        value="{{ $key }}" {{ $key == $verification->country ? 'selected' : ''}}>{{ $val }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <span class="form-text text-danger">{{ $errors->first('country') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputAvatar">Personal Photo (avatar)</label>
                            <input type="file" class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}" name="avatar" id="inputAvatar"
                                   accept="image/jpeg,image/png,image/jpg"
                                   required
                                   @input_disabled($verification->status_processing)>
                            @if ($errors->has('avatar'))
                                <span class="form-text text-danger">{{ $errors->first('avatar') }}</span>
                            @endif
                            <small class="form-text text-muted">Allowed file type extensions are: jpeg, jpg, png. Max
                                size 5 MB
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="inputAvatar">Verification Photo Doc (passport)</label>
                            <input type="file" class="form-control {{ $errors->has('doc_img') ? 'is-invalid' : '' }}" name="doc_img" id="inputAvatar"
                                   accept="image/jpeg,image/png,image/jpg"
                                   required
                                   @input_disabled($verification->status_processing)>
                            @if ($errors->has('doc_img'))
                                <span class="form-text text-danger">{{ $errors->first('doc_img') }}</span>
                            @endif
                            <small class="form-text text-muted">Allowed file type extensions are: jpeg, jpg, png. Max
                                size 5 MB
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="control-label">Your password</label>
                            <input type="password" name="password"
                                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   id="inputPassword"
                                   placeholder="Password" autocomplete="off" required
                                   @input_disabled($verification->status_processing)>
                            @if ($errors->has('password'))
                                <span class="form-text text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <button class="btn btn-primary btn-block" type="submit" @input_disabled($verification->status_processing)>{{$v_lang->title}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
