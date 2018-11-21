@extends('layouts.personal-office')
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>


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
        // Select2
        $.fn.select2.defaults.set("theme", "bootstrap");
        $('select.form-select').select2({minimumResultsForSearch: -1});
        $(".money").maskMoney({thousands: '', decimal: '.'});
    });
</script>
@endpush
@push('page-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.9/select2-bootstrap.css">
@endpush
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">New transfer</h3>

            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="alert alert-no-border alert-warning">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Transfer tax</strong> <br>
                            0.5%
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{Form::open(['route'=> 'personal-office.balance.transfer.post'])}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="user" class="control-label">Member ID</label>
                            <input type="text" class="form-control" name="user" value="{{old('user')}}"
                                   autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="type_balance" class="control-label">Transfer</label>
                            <select name="type_balance" id="type_balance" class="form-control form-select"
                                    data-placeholder="Type balance..."
                                    required>
                                <option value=""></option>
                                <option value="balance">Balance USD</option>
                                <option value="mining_balance">Balance VMC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="amount" class="control-label">Amount USD</label>
                            <input type="text" class="form-control money" placeholder="0.00" name="amount"
                                   onkeyup="$().calculator(this, 0.005)" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="transaction_password" class="control-label">Transaction password</label>
                            <input type="password" class="form-control" name="transaction_password" placeholder="******"
                                   autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Discounted</label>
                            <input type="text" class="form-control discounted" placeholder="0.00" disabled/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-primary" type="submit">Transfer</button>
                    </div>

                    {{Form::close()}}
                </div>

            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Transfer</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Commission</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->from_username}} => {{$item->to_username}}</td>
                                <td>{{$item->method}}</td>
                                <td>{{formatUSD($item->amount)}} $</td>
                                <td>{{formatUSD($item->cost_amount)}} $</td>
                                <td><a href="javascript:;" data-toggle="tooltip" data-placement="top"
                                       data-original-title="{{$item->created_at->format('d/m/Y H:i:s')}}">{{$item->created_at->format('d/m/Y')}}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="text-center text-muted no-margin-bottom">Empty</p>
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
