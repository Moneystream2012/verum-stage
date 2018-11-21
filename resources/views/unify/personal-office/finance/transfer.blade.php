@extends('unify.layouts.personal-office')
@push('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="{{asset_theme('vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{asset_theme('vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $.fn.calculator = function (e, percent) {
            var amount = parseFloat($(e).val());
            percent = parseFloat(percent);
            $(e).parents('.row').find('.discounted').val(Mround(amount * percent + amount));

            function Mround(str) {
                return (Math.round(str * 100) / 100).toFixed(2);
            }
        };
        jQuery(function ($) {
            'use strict';
            $(".money").maskMoney({thousands: '', decimal: '.'});
        });
    </script>
@endpush
@push('page-styles')
    <link rel="stylesheet" href="{{asset_theme('vendor/datatables/dataTables.bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset_theme('vendor/datatables/dataTables.bs4-custom.css')}}"/>
@endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="alert alert-warning mb-0">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>{{$l_lang->tax}}</strong> <br>
                            <span>{{formatUSD($coefficient)}} <small>%</small></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li><i class="icon-"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{Form::open(['route'=> 'personal-office.finance.transfer.post', 'class' => 'form-row'])}}
                    <div class="form-group col-md-3">
                        <label for="user" class="col-form-label">{{$l_lang->member}} ID</label>
                        <input type="text" class="form-control" name="user" value="{{old('user')}}"
                               autocomplete="off" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="type_balance" class="col-form-label">{{$v_lang->title}}</label>
                        <select name="type_balance" id="type_balance" class="form-control"
                                data-placeholder=""
                                required>
                            <option value="">{{$l_lang->select_option}}</option>
                            <option value="balance">{{$l_lang->balance}} USD</option>
                            <option value="mining_balance">{{$l_lang->balance}} VMC</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="amount" class="col-form-label">{{$l_lang->amount}} USD</label>
                        <input type="text" class="form-control money" placeholder="0.00" name="amount"
                               onkeyup="$().calculator(this, 0.005)" autocomplete="off" required/>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="transaction_password"
                                   class="col-form-label">{{$l_lang->transaction_password}}</label>
                            <input type="password" class="form-control" name="transaction_password"
                                   placeholder="******"
                                   autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="col-form-label">{{$v_lang->discounted}}</label>
                        <input type="text" class="form-control discounted" placeholder="0.00" disabled/>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-primary" type="submit">{{$v_lang->title}}</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{$v_lang->title}}</th>
                                <th>{{$l_lang->method}}</th>
                                <th>{{$l_lang->amount}}</th>
                                <th>{{$l_lang->tax}}</th>
                                <th>{{$l_lang->date}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->from_username}} => {{$item->to_username}}</td>
                                    <td>{{$item->method}}</td>
                                    <td>@format_usd($item->amount)</td>
                                    <td>@format_usd($item->cost_amount)</td>
                                    <td>@format_date($item->created_at)</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <p class="text-center text-muted mb-0">{{$l_lang->empty}}</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
