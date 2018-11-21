@extends('layouts.administrator')
@section('title', 'Профиль')
@push('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/js/intlTelInput.min.js"
            integrity="sha256-QCAySImJGNb+zBaYHIvH8T7EnfUe+fcj41t+niXPPAw=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.7/js/utils.js"
            integrity="sha256-B09aYrCSBLxP05N5uY9P/ZSfIlSAoGyXXWxnMfYNE2E=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

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

            $(".money").maskMoney({thousands: '', decimal: '.'});
        });
    </script>
@endpush
@push('page-styles')
    <link rel="stylesheet" href="{{asset('veneto/css/plugins/jquery-select2.min.css')}}">
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
@section('page')
    <div class="container-fluid-md">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default panel-profile-details">
                    <div class="panel-body">
                        <div class="col-sm-5 text-center">
                            <img alt="image" class="img-circle img-profile  margin-md-top"
                                 src="{{ $user->avatar_url }}">
                        </div>
                        <div class="col-sm-7 profile-details">
                            <h3>{{$user->full_name}}</h3>

                            <dl class="margin-sm-bottom">
                                <dt>Created at</dt>
                                <dd>{{$user->created_at  ?? '-'}}</dd>
                            </dl>
                            <dl class="margin-sm-bottom">
                                <dt>Updated at</dt>
                                <dd>{{$user->updated_at ?? '-'}}</dd>
                            </dl>
                            <dl class="margin-sm-bottom">
                                <dt>Last login at</dt>
                                <dd>{{$user->last_login_at  ?? '-'}}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="panel-heading">
                        <p class="panel-title">Пополнение счета</p>
                    </div>
                    <div class="panel-body no-padding">
                        <form method="post"
                              action="{{route('administrator.replenishments.replenish', ['user' => $user])}}">
                            {{csrf_field()}}
                            <div class="panel-body">
                                <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                    <label for="amount" class="control-label">Amount</label>
                                    <input type="text" class="form-control" placeholder="0" name="amount" required
                                           autocomplete="off"/>
                                    @if ($errors->has('amount'))
                                        <span class="help-block">{{ $errors->first('amount') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="replenishment_method" class="control-label">Type balance</label>
                                    <select name="replenishment_balance" class="form-control" required>
                                        <option value="">Select an Option</option>
                                        <option value="balance">Balance USD</option>
                                        <option value="mining_balance">Balance VMC</option>
                                    </select>
                                </div>

                                <button class="btn btn-primary" type="submit">Пополнить</button>
                            </div>
                        </form>
                    </div>

                    <div class="panel-heading">
                        <p class="panel-title">Вычесть от счета</p>
                    </div>
                    <div class="panel-body no-padding">
                        <form method="post"
                              action="{{route('administrator.replenishments.subtract', ['user' => $user])}}">
                            {{csrf_field()}}
                            <div class="panel-body">
                                <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                    <label for="amount" class="control-label">Amount</label>
                                    <input type="text" class="form-control" placeholder="0" name="amount" required
                                           autocomplete="off"/>
                                    @if ($errors->has('amount'))
                                        <span class="help-block">{{ $errors->first('amount') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="replenishment_method" class="control-label">Type balance</label>
                                    <select name="replenishment_balance" class="form-control" required>
                                        <option value="">Select an Option</option>
                                        <option value="balance">Balance USD</option>
                                        <option value="mining_balance">Balance VMC</option>
                                    </select>
                                </div>

                                <button class="btn btn-primary" type="submit">Вычесть</button>
                            </div>
                        </form>
                    </div>

                    {{--<div class="panel-heading">
                        <p class="panel-title">Новое уведомление</p>
                    </div>
                    <div class="panel-body no-padding">
                        <form method="post" action="{{route('administrator.users.send_notice')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <div class="panel-body">
                                <div class="form-group  {{ $errors->has('body') ? ' has-error' : '' }}">
                                    <textarea class="form-control" rows="2" id="body" name="body" placeholder="Текст уведомления." required>{{old('body')}}</textarea>
                                    @if ($errors->has('body'))
                                        <span class="help-block">{{ $errors->first('body') }}</span>
                                    @endif
                                </div>

                                <button class="btn btn-primary" type="submit">Отправить</button>
                            </div>
                        </form>
                    </div>--}}

                    <div class="panel-heading">
                        <p class="panel-title">О пользователе</p>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table no-margin">
                            <tr>
                                <td>User ID:</td>
                                <td>{{$user->id}}</td>
                            </tr>
                            <tr>
                                <td>Логин:</td>
                                <td>{{$user->username}}</td>
                            </tr>
                            <tr>
                                <td>Verification:</td>
                                <td>{{$user->verified_status_text}}</td>
                            </tr>
                            <tr>
                                <td>Спонсор:</td>
                                <td>
                                    <a href="{{route('administrator.users.show', $user->sponsor_id)}}">{{$user->sponsor_id ?? '-'}}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Investment Token USD:</td>
                                <td>@format_usd($user->deposits()->where('active', true)->sum('invest'))</td>
                            </tr><tr>
                                <td>Trading:</td>
                                <td>@format_usd($user->tradings()->where('status', \App\Trading::ACTIVE)->sum('invest'))</td>
                            </tr>
                           {{-- <tr>
                                <td>Rank:</td>
                                <td>{{$user->rank_text}}</td>
                            </tr>--}}

                            <tr>
                                <td>Balance:</td>
                                <td>
                                    @format_usd($user->balance) <br>
                                    @format_vmc($user->mining_balance) / @format_usd(VMCtoUSD($user->mining_balance))
                                </td>
                            </tr>
                            <tr>
                                <td>Cold Balance:</td>
                                <td>
                                    @format_usd($user->cold_balance)
                                </td>
                            </tr>
                            {{--<tr>
                                <td>Direct Bonus:</td>
                                <td>@format_usd($turnover->direct_total ?? 0)</td>
                            </tr>
                            <tr>
                                <td>Binary Bonus:</td>
                                <td>@format_usd($user->binary_total ?? 0)</td>
                            </tr>
                            <tr>
                                <td>Matching Bonus:</td>
                                <td>@format_usd($matching_bonus)</td>
                            </tr>
                            <tr>
                                <td>Overall Bonus:</td>
                                <td>@format_usd($overall_bonus)</td>
                            </tr>--}}
                            <tr>
                                <td>Payouts: Investment Token USD</td>
                                <td>@format_usd($user->deposits()->where('active', true)->sum('profit'))</td>
                            </tr>
                            <tr>
                                <td>Payouts: Trading</td>
                                <td>@format_usd($user->tradings()->where('status', \App\Trading::ACTIVE)->sum('profit'))</td>
                            </tr>
                            {{--<tr>
                                <td>TeamDeveloper:</td>
                                <td>{{$user->team_developer ? 'true' : 'false'}}</td>
                            </tr>
                            <tr>
                                <td>Blocked:</td>
                                <td>{{$user->blocked ? 'true' : 'false'}}</td>
                            </tr>--}}
                            <tr>
                                <td>Old:</td>
                                <td>{{$user->old ? 'true' : 'false'}}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="panel-heading">
                        <p class="panel-title">Действия</p>
                    </div>

                    <div class="panel-body no-padding">
                        <table class="table no-margin">
                            <tr>
                                <td>Пакетов:</td>
                                <td>
                                    <a href="{{route('administrator.deposits.index', $user->id)}}">{{$user->deposits()->count()}}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Trading:</td>
                                <td>
                                    <a href="{{route('administrator.trading.index', $user->id)}}">{{$user->tradings()->count()}}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>ICO Telegram:</td>
                                <td><a href="{{route('administrator.ico.index', $user->id)}}">
                                        @format_usd($user->initial_coin_offerings()->where('ico_type',
                                        'telegram')->sum('amount'))
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Пополнений:</td>
                                <td>
                                    <a href="{{route('administrator.replenishments.index', $user->id)}}">
                                        {{formatUSD($user->replenishments()->where('currency', 'USD')->whereStatus('paid')->sum('amount'))}}
                                        USD</a><br>
                                    <a href="{{route('administrator.replenishments.index', $user->id)}}">
                                        {{formatVMC($user->replenishments()->where('currency', 'BTC')->whereStatus('paid')->sum('amount'))}}
                                        BTC</a><br>
                                    <a href="{{route('administrator.replenishments.index', $user->id)}}">
                                        {{formatVMC($user->replenishments()->where('currency', 'VMC')->whereStatus('paid')->sum('amount'))}}
                                        VMC</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Выводов:</td>
                                <td>
                                    <a href="{{route('administrator.withdraws.index', $user->id)}}">
                                        @format_usd(
                                            -(($withdraws_amount['success']['BTC'] ?? 0)
                                            + ($withdraws_amount['success']['VMC'] ?? 0)))
                                    </a>
                                    <small>
                                        <hr class="no-margin"/>
                                        Processing: <br>
                                        BTC => @format_usd($withdraws_amount['processing']['BTC'] ?? 0) <br>
                                        VMC => @format_usd($withdraws_amount['processing']['VMC'] ?? 0) <br>
                                        <hr class="no-margin"/>
                                        Success: <br>
                                        BTC => @format_usd($withdraws_amount['success']['BTC'] ?? 0) <br>
                                        VMC => @format_usd($withdraws_amount['success']['VMC'] ?? 0)
                                        <hr class="no-margin"/>
                                        Rejection: <br>
                                        BTC => @format_usd($withdraws_amount['rejection']['BTC'] ?? 0) <br>
                                        VMC => @format_usd($withdraws_amount['rejection']['VMC'] ?? 0)
                                    </small>
                            </td>

                            </tr>
                            <tr>
                                <td>Отправил переводов:</td>
                                <td>
                                    <a href="{{route('administrator.transfers.index', $user->id)}}">
                                        {{formatUSD(- $user->transfers()->sum('amount'))}} USD</a>
                                </td>
                            </tr>

                            <tr>
                                <td>Получил переводов:</td>
                                <td>
                                    <a href="{{route('administrator.transfers.have', $user->id)}}">
                                        {{formatUSD($user->have_transfers()->sum('amount'))}} USD</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Обмен USD => VMC:</td>
                                <td>
                                    <a href="{{route('administrator.exchanges.index', ['user_id' => $user->id, 'from_method' => 'balance'])}}">@format_usd($user->exchanges()->where('from_method', 'balance')->sum('amount'))</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Обмен COLD => VMC:</td>
                                <td>
                                    <a href="{{route('administrator.exchanges.index', ['user_id' => $user->id, 'from_method' => 'cold_balance'])}}">@format_usd($user->exchanges()->where('from_method', 'cold_balance')->sum('amount'))</a>
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{--<div class="panel-heading">
                        <p class="panel-title">Turnover: Direct USD</p>
                    </div>
                    <div class="panel-body">
                        <table class="table table-banded table-condensed table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">Week</th>
                                <th></th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center"> {{formatUSD($turnover->direct_week ?? 0)}}</td>
                                <td class="text-center">{{($user->product['mlm_direct_bonus'] ?? 0 ) * 100 }} %</td>
                                <td class="text-center">{{formatUSD(($turnover->direct_week ?? 0) * ($user->product['mlm_direct_bonus'] ?? 0 ))}}</td>
                            </tr>
                            </tbody>
                            <thead>
                            <tr>
                                <th class="text-center">All</th>
                                <th></th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">{{formatUSD($turnover->direct_all ?? 0)}}</td>
                                <th></th>
                                <td class="text-center">{{formatUSD($turnover->direct_total ?? 0)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>--}}

                    {{--<div class="panel-heading">
                        <p class="panel-title">Turnover: Binary USD</p>
                    </div>
                    <div class="panel-body">
                        <table class="table table-banded table-condensed table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">Week</th>
                                <th class="text-center"></th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">{{formatUSD($binary_points->left_week)}}
                                    | {{formatUSD($binary_points->right_week)}}</td>
                                <td class="text-center">{{$user->product['mlm_binary_bonus'] * 100}} %</td>
                                <td class="text-center">{{formatUSD($user->binary_week)}}</td>
                            </tr>
                            </tbody>
                            <thead>
                            <tr>
                                <th class="text-center">All</th>
                                <th></th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">{{formatUSD($binary_points->left_total)}}
                                    | {{formatUSD($binary_points->right_total)}}</td>
                                <td></td>
                                <td class="text-center">{{formatUSD($user->binary_total)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>--}}

                    {{--<div class="panel-heading">
                        <p class="panel-title">Авторизация через социальные сети</p>
                    </div>
                    <div class="panel-body">

                        @if(isset($social_account['vkontakte']))
                            <div class="btn-group margin-sm-horizontal margin-sm-vertical">
                                <a href="{{route('administrator.users.remove_social_account',['vkontakte', $user->id])}}"
                                   class="btn btn-primary"><i class="fa fa-trash"></i></a>
                                <a class="btn btn-default" disabled="">id{{$social_account['vkontakte']}} <i class="fa fa-vk"></i></a>
                            </div>
                        @endif

                        @if(isset($social_account['facebook']))
                            <div class="btn-group margin-sm-horizontal margin-sm-vertical">
                                <a href="{{route('administrator.users.remove_social_account',['facebook', $user->id])}}"
                                   class="btn btn-primary"><i class="fa fa-trash"></i></a>
                                <a class="btn btn-default" disabled="">ID {{$social_account['facebook']}}
                                    <i class="fa fa-facebook-f"></i></a>
                            </div>
                        @endif

                        @if(isset($social_account['instagram']))
                            <div class="btn-group margin-sm-horizontal margin-sm-vertical">
                                <a href="{{route('administrator.users.remove_social_account',['instagram', $user->id])}}"
                                   class="btn btn-primary"><i class="fa fa-trash"></i></a>
                                <a class="btn btn-default" disabled="">ID{{$social_account['instagram']}} <i
                                            class="fa fa-instagram"></i></a>
                            </div>
                        @endif
                        @if(isset($social_account['twitter']))
                            <div class="btn-group margin-sm-horizontal margin-sm-vertical">
                                <a href="{{route('administrator.users.remove_social_account',['twitter', $user->id])}}"
                                   class="btn btn-primary"><i class="fa fa-trash"></i></a>
                                <a class="btn btn-primary" disabled="">ID{{$social_account['twitter']}} <i
                                            class="fa fa-twitter"></i></a>
                            </div>
                        @endif
                    </div>--}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">User data</h4>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="{{route('administrator.users.update')}}" method="post"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <div class="form-group">
                                <label class="control-label">Blocked</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="blocked" {{ !$user->blocked ?: 'checked' }} value="1">
                                        True
                                    </label>

                                    <label class="radio-inline">
                                        <input type="radio" name="blocked" {{ $user->blocked ?: 'checked' }} value="0">
                                        False
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Allow withdraw</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="allow_withdraw" {{ $user->old ? '' : 'checked' }} value="0">
                                        True
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="allow_withdraw" {{ $user->old ? 'checked' : '' }} value="1">
                                        False
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Team Developer</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="team_developer"
                                               {{ !$user->team_developer ?: 'checked' }} value="1">
                                        True
                                    </label>

                                    <label class="radio-inline">
                                        <input type="radio" name="team_developer"
                                               {{ $user->team_developer ?: 'checked' }} value="0">
                                        False
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Enable Cold Balance</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="cold_balance"
                                               {{ !$user->hasSetting('cold_balance') ?: 'checked' }} value="1">
                                        True
                                    </label>

                                    <label class="radio-inline">
                                        <input type="radio" name="cold_balance"
                                               {{ $user->hasSetting('cold_balance') ?: 'checked' }} value="0">
                                        False
                                    </label>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="inputFirstName" class="control-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" id="inputFirstName"
                                       placeholder="First Name" value="{{old('first_name') ?? $user->first_name}}">
                                @if ($errors->has('first_name'))
                                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="inputLastName" class="control-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" id="inputLastName"
                                       placeholder="Last Name"
                                       value="{{old('last_name') ?? $user->last_name}}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                       value="{{old('email') ?? $user->email}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                                <label for="mobile_number" class="control-label">Mobile Number</label>
                                <input type="hidden" name="mobile_code" id="mobile_code" value="UA">
                                <input type="tel" name="mobile_number" class="form-control" id="mobile_number"
                                       value="{{old('mobile_number') ?? $user->mobile_number }}">
                                @if ($errors->has('mobile_number'))
                                    <span class="help-block">{{ $errors->first('mobile_number') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                <label for="country" class="control-label">Country</label>
                                <select class="form-control form-chosen form-select2"
                                        data-placeholder="Choose a Country..."
                                        name="country">
                                    @foreach ($countries as $key => $val)
                                        <option
                                            value="{{ $key }}" {{ $key == $user->country ? 'selected' : ''}}>{{ $val }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <span class="help-block">{{ $errors->first('country') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="inputPassword" class="control-label">Password</label>
                                <input type="password" name="password" class="form-control" id="inputPassword"
                                       placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('transaction_password') ? ' has-error' : '' }}">
                                <label for="inputTransactionPassword" class="control-label">Transaction password</label>
                                <input type="password" name="transaction_password" class="form-control"
                                       id="inputTransactionPassword"
                                       placeholder="Transaction password">
                                @if ($errors->has('transaction_password'))
                                    <span class="help-block">{{ $errors->first('transaction_password') }}</span>
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
