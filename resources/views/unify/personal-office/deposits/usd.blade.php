@extends('unify.layouts.personal-office')
@push('page-styles')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="{{asset_theme('vendor/datatables/dataTables.bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset_theme('vendor/datatables/dataTables.bs4-custom.css')}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
    <style>
        .owl-carousel {
            padding: 0 20px;
        }

        .owl-carousel .owl-nav button.owl-prev {
            left: -8px;
        }

        .owl-carousel .owl-nav button.owl-next {
            right: -8px;
        }

        .owl-theme .owl-nav {
            position: absolute;
            top: 50%;
            margin-top: -25px;
            display: block;
            left: 0;
            right: 0;
            -webkit-tap-highlight-color: transparent;
        }

        .owl-theme .owl-nav [class*='owl-'] {
            font-size: 2rem !important;
            margin: 0 5px;
            display: inline-block;
            cursor: pointer;
            border-radius: 0;
            position: absolute;
            color: #e1e5f1 !important;
        }

        .owl-theme .owl-nav [class*='owl-']:hover,
        .owl-theme .owl-nav [class*='owl-']:focus {
            color: #4266b2 !important;
            outline: none;
        }

        .owl-theme .owl-nav .disabled {
            opacity: 0.5;
            cursor: default;
        }

        .owl-theme .owl-nav.disabled + .owl-dots {
            margin-top: 10px;
        }

        .owl-theme .owl-dots {
            text-align: center;
            -webkit-tap-highlight-color: transparent;
        }

        .owl-theme .owl-dots .owl-dot {
            display: inline-block;
            zoom: 1;
            *display: inline;
        }

        .owl-theme .owl-dots .owl-dot:focus {
            outline: none;
        }

        .owl-theme .owl-dots .owl-dot span {
            width: 10px;
            height: 10px;
            margin: 5px 7px;
            background: #e1e5f1;
            display: block;
            -webkit-backface-visibility: visible;
            transition: opacity 200ms ease;
            border-radius: 30px;
        }

        .owl-theme .owl-dots .owl-dot.active span,
        .owl-theme .owl-dots .owl-dot:hover span {
            background: #4266b2;
        }
    </style>
@endpush
@push('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{asset_theme('vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{asset_theme('vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    <script>
        $(function () {
            $('.owl-carousel').owlCarousel({
                loop: false,
                margin: 20,
                responsiveClass: true,
                nav: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 2,
                    },
                    1000: {
                        items: 2,
                    }
                }
            });
            $(".btn-paymant").on('click', function () {
                event.preventDefault();
                let data = $(event.target).data();
                let invest = $('.plan-'+data.plan).find('.amount').val();
                $('.payment-balance-deposit-'+data.plan).find('[name="invest"]').val(invest);
                $('.payment-mining_balance-deposit-'+data.plan).find('[name="invest"]').val(invest);
                $('.payment-cold_balance-deposit-'+data.plan).find('[name="invest"]').val(invest);
                $('.payment-' + data.method + '-' + data.service + '-' + data.plan).submit();
            });

            $.fn.calculator = function (plan, amount, percent) {
                amount = parseFloat($(amount).val());
                percent = parseFloat(percent/100);

                $('.plan-'+plan).find('.discounted').text(Mround(amount*percent));
                function Mround(str) {
                    return (Math.round(str * 100) / 100).toFixed(2);
                }
            };
            jQuery(function ($) {
                'use strict';
                $(".money").maskMoney({thousands: '', decimal: '.'});
            });
        });
    </script>
@endpush
@section('main-content')
    <div class="row gutters">
        <div class="col-12">
            <div class="alert alert-info"><span class="text-danger">*</span> {{$v_lang->alert['info']}} / {{$l_lang->month}}</div>
            <div class="card">
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
                    <div class="owl-carousel owl-theme">
                        @foreach($products as $product)
                            <div class="plan-three plan-{{$product['plan']}}">
                                <div class="pricing-header">
                                    <i class="icon-briefcase4"></i>
                                    <h4 class="plan-title">
                                        {{$product['name']}}
                                    </h4>
                                    <div class="plan-cost">
                                        <span class="plan-price">{{$product['percent']}}%</span>
                                        <span class="plan-type">/{{$l_lang->month}}</span>
                                    </div>
                                </div>
                                <ul class="plan-features">
                                    <li>{{$v_lang->product['term']}} {{$product['payout_count']}} {{$l_lang->month}}</li>
{{--                                    <li>{{$v_lang->product['monthly_income']}} {{formatUSD($product->monthly_income)}} {{$product->currency}}</li>--}}
{{--                                    <li>{{$v_lang->product['overall_profit']}} {{formatUSD($product->payout )}} {{$product->currency}}</li>--}}
{{--                                    <li>{{$v_lang->product['clear_profit']}} {{formatUSD($product->payout + $product->price)}} {{$product->currency}}</li>--}}
                                    <li>
                                        <div class="row h-100 ">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control amount money" onkeyup="$().calculator({{$product['plan']}}, this, {{$product['percent']}})" placeholder="Invest Amount">
                                            </div>
                                            <div class="col-md-7 align-self-center text-right">
                                                <div class="">
                                                    {{$v_lang->product['monthly_income']}}<br><strong class="discounted">0.00</strong> USD
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="plan-select dropup">
                                    @include('unify.personal-office.partials.invest.usd_vmc', ['service'=> 'deposit', 'product'=> $product, 'currency' => 'USD'])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped mb-0 table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{$l_lang->invest}}</th>
                                <th>{{$v_lang->table['number_of']}}</th>
                                <th>{{$v_lang->table['payout']}}</th>
                                <th>{{$v_lang->table['profit']}}</th>
                                <th>{{$v_lang->table['diff_days']}}</th>
                                <th>{{$v_lang->table['calculate_date']}}</th>
                                <th>{{$v_lang->table['create_date']}}</th>
                                <th>{{$v_lang->table['final_date']}}</th>
                                <th>{{$v_lang->table['status']}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>@format_usd($item->invest, true)</td>
                                    <td>{{$item->number_of}} /
                                        {{$item->payout_count}}</td>
                                    <td>@format_usd($item->payout)</td>
                                    <td>@format_usd($item->profit)</td>
                                    <td>{{$item->calculate_at->diffInDays()}}</td>
                                    <td>
                                        @format_date($item->calculate_at)
                                    </td>
                                    <td>
                                        @format_date($item->created_at)
                                    </td>
                                    <td>
                                        @format_date($item->final_at)
                                    </td>
                                    <td>
                                        {{$item->status}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
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
