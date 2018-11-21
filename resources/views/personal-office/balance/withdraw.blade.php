@extends('layouts.personal-office')
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script>
    $(".money").maskMoney({thousands: '', decimal: '.'});
</script>
@endpush
@section('page')
    <div class="container-fluid-md">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">New withdraw</h3>
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="alert alert-info">
                    Requests for withdrawal of funds are processed by the operator up to 10 working days.
                </div>
                <div class="alert alert-no-border alert-warning">
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Withdraw tax</strong> <br>
                            <p>{{$coefficient}}</p>
                        </div>
                        <div class="col-sm-3">
                            <strong>Min Amount</strong> <br>
                            <p>@format_usd(50)</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{Form::open(['route'=> 'personal-office.balance.withdraw.post'])}}

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="amount" class="control-label">Amount USD</label>
                            <input type="text" class="form-control money" placeholder="0.00" name="amount" autocomplete="off" required/>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="payment_method" class="control-label">Type withdraw</label>
                            <select name="type_withdraw" class="form-control" required>
                                <option value="">Select an Option</option>
                                <option value="balance-btc">Balance USD => BTC</option>
                                <option value="balance-vmc">Balance USD => VMC</option>
                                <option value="mining_balance-btc">Balance VMC => BTC</option>
                                <option value="mining_balance-vmc">Balance VMC => VMC</option>
                                <option value="btc_balance-btc">Balance BTC => BTC</option>
                                <option value="btc_balance-vmc">Balance BTC => VMC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="wallet_address" class="control-label">Wallet Address</label>
                            <input type="text" class="form-control" placeholder="Wallet Address" name="wallet_address"
                                   autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="transaction_password" class="control-label">Transaction password</label>
                            <input type="password" class="form-control" autocomplete="off" name="transaction_password"
                                   placeholder="******" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-primary"
                                {{Carbon\Carbon::now()->isMonday() ?: '_disabled'}} type="submit">Withdraw
                        </button>
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
                            <th>Withdraw</th>
                            <th>Amount</th>
                            <th>Commission</th>
                            <th>Wallet Address</th>
                            <th>Txid</th>
                            <th>Processing</th>
                            <th>Creation</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>

                                <td>{{$item->from_method}} => {{$item->to_method}}</td>
                                <td>{{formatUSD($item->amount)}}</td>
                                <td>{{formatUSD($item->cost_amount)}}</td>

                                <td>
                                    <span style="font-size: 90%">
                                    {{$item->wallet_address}}
                                    </span>
                                </td>

                                <td>
                                    @if($item->tx)
                                        <a href="{{$item->link_tx}}" target="_blank"
                                           style="font-size: 90%">{{str_limit($item->tx, 10)}}</a>
                                    @else
                                        -
                                @endif
                                <td>
                                    @if($item->done_at)
                                        @format_date($item->done_at)
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @format_date($item->created_at)
                                </td>
                                <td>
								<span
                                    class="label {{$item->status === 0 ? 'label-warning': ''}}  {{ $item->status === 1 ? 'label-success' : ''}}  {{$item->status === 2 ? 'label-danger': ''}} ">{{$item->status_text}}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
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
