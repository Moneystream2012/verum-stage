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
            <div class="card">
                {{--@if($auth->cold_balance > 0)
                <div class="alert alert-warning mb-0">
                    <div class="row">
                        <div class="col">
                            <strong>Cold Balance</strong> <br>
                            <span>@format_usd($auth->cold_balance)</span>
                        </div>
                    </div>
                </div>
                @endif--}}
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
                    {{Form::open(['route'=> 'personal-office.finance.exchange.post', 'class' => 'form-row'])}}
                    <div class="form-group col-md-6">
                        <label for="amount" class="col-form-label">
                            {{$l_lang->amount}}
                            <span id="amount_currency"></span>
                        </label>
                        <input type="text" class="form-control money" placeholder="0.00" name="amount" required
                               autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exchange" class="col-form-label">{{$v_lang->title}}</label>
                        <select name="exchange" class="form-control" id="exchange"
                                required>
                            <option value="">{{$l_lang->select_option}}</option>
                            <option value="balance:mining_balance">{{$l_lang->balance}} USD => {{$l_lang->balance}} VMC</option>
                            {{--<option @input_disabled(!$enable_cold_balance) value="cold_balance:mining_balance">{{$l_lang->balance}} COLD => {{$l_lang->balance}} VMC</option>--}}
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
                                <th>{{$l_lang->date}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->from_method}} => {{$item->to_method}}</td>
                                    <td>@format_usd($item->amount)</td>
                                    <td>@format_date($item->created_at)</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
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
