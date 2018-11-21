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
                <h3 class="panel-title">New exchange</h3>
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="row">
                    {{Form::open(['route'=> 'personal-office.balance.exchange.post'])}}
                    <input type="hidden" name="type" value="exchange">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="amount" class="control-label">Amount</label>
                            <input type="text" class="form-control money" placeholder="0.00" autocomplete="off"
                                   name="amount"
                                   required/>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Exchange</label>
                            <input type="text" class="form-control" value="Balance USD => Balance VMC" disabled/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-primary" type="submit">Exchange</button>
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
                            <th>Exchange</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->from_method}} => {{$item->to_method}}</td>
                                <td>{{formatUSD($item->amount)}} $</td>
                                <td><a href="javascript:;" data-toggle="tooltip" data-placement="top"
                                       data-original-title="{{$item->created_at->format('d/m/Y H:i:s')}}">{{$item->created_at->format('d/m/Y')}}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
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
