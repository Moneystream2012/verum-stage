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
                    <li class="list-group-item">{{$l_lang->member_id}}: {{$auth->id}}</li>
                    <li class="list-group-item">{{$l_lang->username}}: {{$auth->username}}</li>
                    <li class="list-group-item">{{$l_lang->email}}: {{$auth->email}}</li>
                    <li class="list-group-item">{{$l_lang->sponsor}}: {{$auth->sponsor()->value('username') ?? '-'}}</li>
                    <li class="list-group-item">{{$l_lang->country}}: {{$auth->country_name}}</li>
                    <li class="list-group-item">{{$l_lang->mobile_number}}: {{$auth->mobile_number_format}}</li>
                </ul>
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
        <div class="col-md-7">
            <div class="card">
                <div class="card-header text-center">{{$l_lang->edit_profile}}</div>
                @if($auth->verified)
                <p class="p-3 alert-warning text-center mb-0">
                    {{$v_lang->msg['info']}}
                </p>
                @endif
                <div class="card-body">
                    <form role="form" action="{{route('personal-office.profile.update')}}" method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="inputFirstName" class="control-label">First Name</label>
                            <input type="text" name="first_name"
                                   class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                   id="inputFirstName"
                                   placeholder="First Name" value="{{old('first_name') ?? $auth->first_name}}"
                                   autocomplete="off">
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
                                   value="{{old('last_name') ?? $auth->last_name}}" autocomplete="off">
                            @if ($errors->has('last_name'))
                                <span class="form-text text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>

                        {{--<div class="form-group hidden {{ $errors->has('email') ? ' is-invalid' : '' }}">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                   value="{{old('email') ?? $auth->email}}" autocomplete="off">
                            @if ($errors->has('email'))
                                <span class="form-text text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>--}}

                        <div class="form-group">
                            <label for="mobile_number" class="control-label">Mobile Number</label>
                            <input type="hidden" name="mobile_code" id="mobile_code" value="UA">
                            <input type="tel" name="mobile_number"
                                   class="form-control {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}"
                                   id="mobile_number"
                                   value="{{old('mobile_number') ?? $auth->mobile_number }}" autocomplete="off">
                            @if ($errors->has('mobile_number'))
                                <span class="form-text text-danger">{{ $errors->first('mobile_number') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="country" class="control-label">Country</label>
                            <select
                                class="form-control form-chosen form-select2 {{ $errors->has('country') ? ' is-invalid' : '' }}" data-placeholder="Choose a Country..."
                                name="country">
                                @foreach ($countries as $key => $val)
                                    <option
                                        value="{{ $key }}" {{ $key == $auth->country ? 'selected' : ''}}>{{ $val }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <span class="form-text text-danger">{{ $errors->first('country') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputAvatar">Avatar</label>
                            <input type="file" class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}" name="avatar" id="inputAvatar"
                                   accept="image/jpeg,image/png,image/jpg">
                            @if ($errors->has('avatar'))
                                <span class="form-text text-danger">{{ $errors->first('avatar') }}</span>
                            @endif
                            <small class="form-text text-muted">Allowed file type extensions are: jpeg, jpg, png. Max
                                size 1 MB
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="control-label">Your password</label>
                            <input type="password" name="password"
                                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   id="inputPassword"
                                   placeholder="Password" autocomplete="off" required>
                            @if ($errors->has('password'))
                                <span class="form-text text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <button class="btn btn-block btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
