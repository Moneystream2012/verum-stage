@extends('unify.layouts.personal-office')
@push('page-styles')
    <link rel="stylesheet" href="{{asset_theme('vendor/datatables/dataTables.bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset_theme('vendor/datatables/dataTables.bs4-custom.css')}}"/>
@endpush
@push('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="{{asset_theme('vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{asset_theme('vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".money").maskMoney({thousands: '', decimal: '.'});
            /*$("#replenishment_balance").on('change', function () {
                var currency = this.value.split('_')[0];
                $('#amount_currency').text(currency.toUpperCase());
                if (currency == 'btc') {
                    $(".money").maskMoney({thousands: '', decimal: '.', precision: 4}).attr('placeholder', '0.0000');
                } else {
                    $(".money").maskMoney({thousands: '', decimal: '.', precision: 2}).attr('placeholder', '0.00');
                }
            });
            $("#replenishment_method").on('change', function () {
                if (this.value == 'perfect_money' || this.value == 'verumcoin') {
                    $("#replenishment_balance option").each(function () {
                        if (this.value == 'mining_balance') {
                            $(this).prop('selected', true);
                            $(this).change();
                            return;
                        }
                        $(this).prop('disabled', 'disabled');
                    });
                } else {
                    $("#replenishment_balance option").each(function () {
                        $(this).removeAttr('disabled')
                    });
                }
            });*/
        });
    </script>
@endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="alert alert-info">{!! $v_lang->alert['info'] !!}</div>
            <div class="card">
                <div class="alert alert-warning mb-0">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>{{$l_lang->tax}}</strong> <br>
                            <span>{{formatUSD($coefficient['usd'])}} <small>%</small></span>
                        </div>
                        <div class="col-md-3">
                            <strong>{{$l_lang->minimum}}</strong> <br>
                            <span>@format_usd($min['usd'])</span>
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
                    {{Form::open(['route'=> 'personal-office.replenishment.post', 'class' => 'form-row'])}}
                        <div class="form-group col-md-4">
                            <label for="amount" class="col-form-label">
                                {{$l_lang->amount}}
                                <span id="amount_currency"></span>
                            </label>
                            <input type="text" class="form-control money" placeholder="0.00" name="amount" required
                                   autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="method" class="col-form-label">{{$l_lang->method}}</label>
                            <select name="method" class="form-control" id="replenishment_method"
                                    required>
                                <option value="">{{$l_lang->select_option}}</option>
                                <option value="bitcoin">Bitcoin (altcoins)</option>
                                {{--<option value="perfect_money">Perfect Money</option>--}}
                                <option value="verumcoin">Verumcoin</option>
                                {{--<option value="walletone">WalletOne (Visa/MasterCard)</option>--}}
                                {{--<option value="advcash">AdvCash</option>--}}
                                <option value="yandex-money">Yandex Money (Visa/MasterCard)</option>
                                <option value="free-kassa">Free Kassa</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="type_balance" class="col-form-label">{{$l_lang->balance}}</label>
                            <select name="type_balance" class="form-control" id="type_balance"
                                    required>
                                <option value="">{{$l_lang->select_option}}</option>
                                <option value="balance">{{$l_lang->balance}} USD</option>
                                <option value="mining_balance">{{$l_lang->balance}} VMC</option>
                            </select>
                        </div>
                        <div class="col-12">
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
                        <table id="datatable" class="table table-striped mb-0 table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{$v_lang->title}}</th>
                                    <th>{{$l_lang->amount}}</th>
                                    <th>{{$l_lang->tax}}</th>
                                    <th>{{$l_lang->currency}}</th>
                                    <th>{{$l_lang->status}}</th>
                                    <th>{{$l_lang->date}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>
                                        <a href="{{$item->payment_url ?? '#'}}" target="_blank">{{$item->id}}</a>
                                    </td>
                                    <td>{{$item->method}} => {{$item->to}}</td>
                                    <td>@format_usd($item->amount)</td>
                                    <td>@format_usd($item->cost_amount)</td>
                                    <td>{{$item->currency}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>{{$item->created_at}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
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
    </div>
@endsection
