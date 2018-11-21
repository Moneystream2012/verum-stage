@extends('layouts.personal-office')
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
<script>
    $('#transferModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var modal = $(this);
        modal.find('#available_amount_transfer').text('').text(button.data('available_amount_transfer').toFixed(2));
        modal.find('[name="deposit_id"]').val('').val(button.data('deposit_id'));
        modal.find('[name="amount_transfer"]').val('').attr('max', button.data('available_amount_transfer').toFixed(2));
    });

    $(".btn-paymant").on('click', function () {
        event.preventDefault();
        var data = $(event.target).data();
        console.log(data)
        $.confirm({
            title: 'Confirm Payment?',
            content: 'Price: ' + data.price.toFixed(2) + ' BTC',
            type: 'green',
            buttons: {
                ok: {
                    text: 'Pay ' + data.price.toFixed(2) + ' BTC',
                    btnClass: 'btn-success',
                    keys: ['enter'],
                    action: function () {
                        $('.payment-' + data.method + '-' + data.service + '-' + data.plan).submit();
                    }
                },
                cancel: function () {
                }
            }
        });
    });
</script>
@endpush
@section('page')
    <div class="container-fluid-md">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-list-alt text-success"></i> List Products</h4>
                        <p class="alert alert-info"><span class="text-danger">*</span> The interest tax may vary  from 15% to 25%</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @foreach($products as $plan => $product)
                                <?php $product->id = $plan;?>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div
                                        class="panel product product-{{$product->count ?? 0 > 0 ? '1' : '0'}}  @if($product->best) product-best  @endif @if($plan >= 7) product-disabled @endif">
                                        <div
                                            class="product-body product-body-{{$product->count ?? 0 > 0 ? '1' : '0'}}">
                                    <span
                                        class="label product-label product-label-{{$product->count ?? 0 > 0 ? '1' : '0'}}"> {{$product->count ?? 0}} </span>
                                            <span class="label-title">Count</span>
                                            <ul class="list-group no-margin">
                                                <li class="list-group-item">
                                                    <span class="text-muted">Number of payments</span>
                                                    <span class="pull-right">{{$product->payout_count}}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted">Payout</span>
                                                    <span class="pull-right">1 month</span>
                                                </li>
                                                <li class="list-group-item">
                                                            <span
                                                                class="text-muted">Forecasting percent per month <span class="text-danger">*</span> </span>
                                                    <span class="pull-right">{{$product->percent}} %</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted"> Clear forecasting profit <span class="text-danger">*</span></span>
                                                    <span class="pull-right">
                                                        {{formatUSD($product->payout)}}
                                                    </span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted">Overall forecasting profit <span class="text-danger">*</span></span>
                                                    <span class="pull-right">
                                                        {{formatUSD($product->payout + $product->price)}} BTC
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-footer panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="h4">{{$product->name}}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="btn-group pull-right">
                                                        @include('include.payment.btn',['service'=> 'deposit', 'product'=> $product])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-briefcase text-success"></i> My products</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @foreach($data as $item)
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="panel product product-0">
                                        <div class="product-body product-body-0">
                                            <span class="label product-label product-label-1">
                                                {{$item->calculate_at->diffInDays()}}
                                            </span>

                                            <span class="label-title">Calculate diff Days</span>
                                            <ul class="list-group no-margin">
                                                <li class="list-group-item">
                                                    <span class="text-muted">ID</span>
                                                    <span class="pull-right">{{$item->id}}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted">Name</span>
                                                    <span class="pull-right">{{$item->product['name']}}</span>
                                                </li>
                                                {{--<li class="list-group-item">
                                                    <span class="text-muted">Payout</span>
                                                    <span class="pull-right">@format_usd($item->product['payout'])</span>
                                                </li>--}}
                                                <li class="list-group-item">
                                                    <span class="text-muted">Number of</span>
                                                    <span class="pull-right">
                                                        {{$item->number_of}} /
                                                        {{$item->product['payout_count']}}
                                                    </span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted">Profit</span>
                                                    <span class="pull-right">@format_usd($item->profit)</span>
                                                </li>
                                                {{--<li class="list-group-item">
                                                    <span class="text-muted">Available</span>
                                                    <span class="pull-right">@format_usd($item->available_amount_transfer)</span>
                                                </li>--}}
                                                <li class="list-group-item">
                                                    <span class="text-muted">Calculate date</span>
                                                    <span class="pull-right">
                                                        <a href="javascript:;" data-toggle="tooltip"
                                                           data-placement="top"
                                                           data-original-title="{{$item->calculate_at->format('d/m/Y H:i:s')}}">{{$item->calculate_at->format('d/m/Y')}}</a>
                                                    </span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted">Create date</span>
                                                    <span class="pull-right">
                                                        <a href="javascript:;" data-toggle="tooltip"
                                                           data-placement="top"
                                                           data-original-title="{{$item->created_at->format('d/m/Y H:i:s')}}">{{$item->created_at->format('d/m/Y')}}</a>
                                                    </span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="text-muted">Final date</span>
                                                    <span class="pull-right">
                                                                <a href="javascript:;" data-toggle="tooltip"
                                                                   data-placement="top"
                                                                   data-original-title="{{$item->final_at->format('d/m/Y H:i:s')}}">{{$item->final_at->format('d/m/Y')}}</a>

                                                            </span>
                                                </li>

                                            </ul>
                                        </div>

                                        {{--<div class="panel-footer clearfix ">
                                            <div class="margin-xs-vertical">
                                                <span class="text-muted valign-middle pull-left h6 margin-top">Withdrawal</span>
                                                <div class="pull-right">
                                                    @if($available_amount_transfer = $item['available_amount_transfer'])
                                                        <a href="#transferModal"
                                                           class="btn btn-sm btn-success"
                                                           data-toggle="modal"
                                                           data-target="#transferModal"
                                                           data-deposit_id="{{$item['id']}}"
                                                           data-available_amount_transfer="{{$available_amount_transfer}}">
                                                            Get
                                                        </a>
                                                    @else
                                                        <a href="javascript:;"
                                                           class="btn btn-default text-muted disabled"
                                                        >
                                                            @if ($item->profit > 0 && $item->withdrawal_at)
                                                                <i class="fa fa-clock-o"></i> {{Carbon\Carbon::now()->diffForHumans( $item->withdrawal_at->endOfDay(), true) }}
                                                            @else
                                                                No money
                                                            @endif
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>--}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="transferModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Output to Balance</h4>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(['route' => 'personal-office.products.deposits.transfer']) }}
                        <div class="form-group margin-sm-bottom">
                            <div class="input-group">
                                <input type="hidden" name="deposit_id" value="0">
                                <input type="number" class="form-control" name="amount_transfer" min="0.01" max="1.00"
                                       step="0.01"
                                       required autocomplete="off" placeholder="0.00">

                                <div class="input-group-btn">
                                    <button tabindex="-1" class="btn btn-primary" type="submit">Get</button>
                                </div>
                            </div>
                            <p class="help-block small text-muted margin-xs-vertical">Available amount: <strong><span
                                        id="available_amount_transfer">0.00</span> $</strong></p>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
