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
        $(function () {
            $(".money").maskMoney({thousands: '', decimal: '.'});

            $.fn.calculator = function (amount, percent) {
                amount = parseFloat($(amount).val());
                percent = parseFloat(percent / 100);

                $('#payout').val(Mround(amount*percent));
                function Mround(str) {
                    return (Math.round(str * 100) / 100).toFixed(2);
                }
            };
        });
    </script>
@endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="alert alert-info"><span class="text-danger">*</span> {{$v_lang->alert['info']}} / {{$l_lang->day}}</div>
            <div class="card">
                <div class="alert alert-warning mb-0">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>{{$v_lang->percent_payout}}</strong> <br>
                            <span>{{formatUSD($percent_payout)}}% <small class="text-uppercase">{{$l_lang->day}}</small></span>
                        </div>
                        <div class="col-md-3">
                            <strong>{{$l_lang->minimum}}</strong> <br>
                            <span>@format_usd($invest->min)</span>
                        </div>
                        <div class="col-md-3">
                            <strong>{{$l_lang->maximum}}</strong> <br>
                            <span>@format_usd($invest->max)</span>
                        </div>
                        <div class="col-md-3">
                            <strong>{{$v_lang->term_of}}</strong> <br>
                            <span>{{$payout_count}} <small class="text-uppercase">{{$l_lang->day}}</small></span>
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
                    {{Form::open(['route'=> 'personal-office.trading.invest', 'class' => 'form-row'])}}
                    <div class="form-group col-md-6">
                        <label for="amount" class="col-form-label">{{$l_lang->amount}} USD</label>
                        <input type="text" class="form-control money" onkeyup="$().calculator(this, {{$percent_payout}})" placeholder="0.00" name="amount"
                               autocomplete="off" required/>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="payment_method" class="col-form-label">{{$l_lang->payment}}</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">{{$l_lang->select_option}}</option>
                                <option value="balance">{{$l_lang->balance}} USD</option>
                                <option value="mining_balance">{{$l_lang->balance}} VMC</option>
                                @if($enable_cold_balance)
                                    <option value="cold_balance">Cold {{$l_lang->balance}}</option>
                                @endif
                        </select>
                    </div>
                    {{--<div class="form-group col-md-4">
                        <label for="payout" class="col-form-label">{{$v_lang->payout}}</label>
                        <input type="text" class="form-control" id="payout" placeholder="0.00" readonly>
                    </div>--}}
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">{{$l_lang->invest}}</button>
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
                                <th>{{$l_lang->invest}}</th>
                                <th>{{$v_lang->payout}}</th>
                                <th>{{$v_lang->profit}}</th>
                                <th>{{$v_lang->number_of}}</th>
                                <th>{{$v_lang->calculate_at}}</th>
                                <th>{{$v_lang->created_at}}</th>
                                <th>{{$v_lang->final_at}}</th>
                                <th>{{$l_lang->status}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>@format_usd($item->invest)</td>
                                    <td>@format_usd($item->payout)</td>
                                    <td>@format_usd($item->profit)</td>
                                    <td>{{$item->number_of_payout}}</td>
                                    <td>@format_date($item->calculate_at)</td>
                                    <td>@format_date($item->created_at)</td>
                                    <td>@format_date($item->final_at)</td>
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
