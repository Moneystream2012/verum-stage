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
        $(".money").maskMoney({thousands: '', decimal: '.'});
    </script>
@endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            @if(!$auth->verified)
                <div class="alert alert-danger">{!! $v_lang->alert_danger !!}</div>
            @endif
            <div class="alert alert-info">{{$v_lang->alert_info}}</div>
            <div class="card">
                <div class="alert alert-warning mb-0">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>{{$l_lang->tax}}</strong> <br>
                            <span>{{formatUSD($coefficient['usd'])}} <small>%</small></span>
                        </div>
                        <div class="col-md-3">
                            <strong>{{$l_lang->minimum}}</strong> <br>
                            <span>@format_usd($min)</span>
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
                    {{Form::open(['route'=> 'personal-office.finance.withdraw.post', 'class' => 'form-row'])}}
                    <div class="form-group col-md-2">
                        <label for="amount" class="col-form-label">{{$l_lang->amount}} USD</label>
                        <input type="text" class="form-control money" placeholder="0.00" name="amount"
                               autocomplete="off" required/>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="payment_method" class="col-form-label">{{$v_lang->title}}</label>
                        <select name="type_withdraw" id="payment_method" class="form-control" required>
                            <option value="">{{$l_lang->select_option}}</option>
                            <optgroup label="{{$l_lang->balance}} USD">
                                <option value="balance-BTC">{{$l_lang->balance}} USD => BTC</option>
                                <option value="balance-VMC">{{$l_lang->balance}} USD => VMC</option>
                                <option value="balance-RUB">{{$l_lang->balance}} USD => Yandex Money</option>
                            </optgroup>
                            <optgroup label="{{$l_lang->balance}} VMC">
                                <option value="mining_balance-BTC">{{$l_lang->balance}} VMC => BTC</option>
                                <option value="mining_balance-VMC">{{$l_lang->balance}} VMC => VMC</option>
                                <option value="mining_balance-RUB">{{$l_lang->balance}} VMC => Yandex Money</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="wallet_address" class="col-form-label">{{$v_lang->wallet_address}}</label>
                        <input type="text" class="form-control" placeholder="{{$v_lang->wallet_address}}"
                               name="wallet_address"
                               autocomplete="off" required/>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="transaction_password" class="coefficient">{{$l_lang->transaction_password}}</label>
                        <input type="password" class="form-control" autocomplete="off"
                               name="transaction_password"
                               placeholder="******" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" @input_disabled(!$auth->verified) type="submit">{{$v_lang->title}}</button>
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
                                <th>{{$l_lang->amount}}</th>
                                <th>{{$l_lang->tax}}</th>
                                <th>{{$v_lang->wallet_address}}</th>
                                <th>{{$v_lang->txid}}</th>
                                <th>{{$v_lang->processed}}</th>
                                <th>{{$l_lang->date}}</th>
                                <th>{{$l_lang->status}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->from_method}} => {{$item->to_method}}</td>
                                    <td>@format_usd($item->amount)</td>
                                    <td>@format_usd($item->cost_amount)</td>
                                    <td>
                                        <small>{{$item->wallet_address}}</small>
                                    </td>
                                    <td>
                                        @if($item->tx)
                                            <a href="{{$item->link_tx}}" target="_blank"
                                               style="font-size: 90%">{{str_limit($item->tx, 10)}}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>@format_date($item->done_at)</td>
                                    <td>@format_date($item->created_at)</td>
                                    <td>{{$item->status_text}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
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
