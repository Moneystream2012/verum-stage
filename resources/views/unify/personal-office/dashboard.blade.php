@extends('unify.layouts.personal-office')
@push('page-styles')
    {!! Charts::styles() !!}
@endpush

@push('page-scripts')
    {!! Charts::scripts() !!}
    <script>
        /*(function (b, i, t, C, O, I, N) {
            window.addEventListener('load', function () {
                if (b.getElementById(C)) return;
                I = b.createElement(i), N = b.getElementsByTagName(i)[0];
                I.src = t;
                I.id = C;
                N.parentNode.insertBefore(I, N);
            }, false)
        })(document, 'script', 'https://widgets.bitcoin.com/widget.js', 'btcwdgt');*/
        jQuery.noConflict();
        $(document).ready(function () {
            $('#flash-overlay-modal').modal();
        });
    </script>
    {!! $chart->script() !!}
@endpush
@section('main-content')
    <div class="row gutters ">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="row gutters">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="stats-widget">
                                <a href="{{route('personal-office.products.deposits.usd')}}"
                                   class="stats-label">{{$deposits['count']}}</a>
                                <div class="stats-widget-header">
                                    <i class="icon-briefcase4"></i>
                                </div>
                                <div class="stats-widget-body">
                                    <!-- Row start -->
                                    <ul class="row no-gutters align-items-center">
                                        <li class="col-7">
                                            <h6 class="title">Invest Token USD</h6>
                                        </li>
                                        <li class="col-5">
                                            <h4 class="total">
                                                <small>{{formatUSD($deposits['invest'])}}</small>
                                            </h4>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="stats-widget">
                                <a href="{{route('personal-office.trading.index')}}"
                                   class="stats-label">{{$tradings['count']}}</a>
                                <div class="stats-widget-header">
                                    <i class="icon-briefcase4"></i>
                                </div>
                                <div class="stats-widget-body">
                                    <!-- Row start -->
                                    <ul class="row no-gutters align-items-center">
                                        <li class="col-7">
                                            <h6 class="title">Invest Global USD</h6>
                                        </li>
                                        <li class="col-5">
                                            <h4 class="total">
                                                <small>{{formatUSD($tradings['invest'])}}</small>
                                            </h4>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>

            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-8">
            <div class="card">
                <div class="card-header pb-1">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="h4 m-0 text-primary">
                                $ {{formatUSD(config('mlm.currencies.VMC.USD'))}}
                            </div>
                            <small class="text-muted">VMC/USD</small>
                        </div>
                        <div class="col text-right">
                            <span class="text-muted">Price Verumcoin</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    {!! $chart->html() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="#" class="block-140">
                <div class="icon secondary">
                    <i class="icon-monetization_on"></i>
                </div>
                <h5>{{formatUSD($auth->balance)}}</h5>
                <p>{{$l_lang->balance}} USD</p>
            </a>
        </div>
        <div class="col">
            <a href="#" class="block-140">
                <div class="icon secondary">
                    <i class="icon-monetization_on"></i>
                </div>
                <h5 style="font-size: 95%">{{formatUSD(VMCtoUSD($auth->mining_balance))}} USD / {{formatVMC($auth->mining_balance)}} VMC</h5>
                <p>{{$l_lang->balance}} VMC</p>
            </a>
        </div>
        <div class="col">
            <a href="#" class="block-140">
                <div class="icon primary">
                    <i class="icon-flow-tree"></i>
                </div>
                <h5>{{formatUSD($turnover->direct_all ?? 0.00)}}</h5>
                <p>{{$l_lang->turnover}} USD</p>
            </a>
        </div>
        <div class="col">
            <a href="#" class="block-140">
                <div class="icon primary">
                    <i class="icon-gift"></i>
                </div>
                <h5>{{formatUSD($turnover->direct_total ?? 0.00)}}</h5>
                <p>{{$l_lang->bonus}} USD</p>
            </a>
        </div>
    </div>

    {{--<div class="row gutters hidden">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="panel panel-metric panel-metric-sm">
                        <div class="panel-body panel-body-default">
                            <div class="metric-content metric-icon">
                                <div class="value" style="font-size: 17px; margin-right: 15px">
                                    {{$next_rank['text_rank']}} <br>
                                    <small>@format_usd($next_rank['reward'])</small>
                                </div>
                                <div class="icon">
                                    <span class="text-muted">Turnover Binary:</span> {{formatUSD($next_rank['binary'])}}
                                    <br>
                                    <span class="text-muted">Turnover Direct:</span> {{formatUSD($next_rank['direct'])}}
                                </div>
                                <header>
                                    <h4 class="thin text-muted padding-sm-vertical">Next Rank</h4>
                                </header>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="panel panel-metric panel-metric-sm">
                        <div class="panel-body panel-body-default">
                            <div class="metric-content metric-icon">
                                <div class="value" style="font-size: 17px">
                                    {{$auth->team_developer ? '' : 'NOT '}} ACTIVE
                                </div>
                                <div class="icon">
                                    <i class="fa fa-toggle-{{$auth->team_developer ? 'on' : 'off'}}"></i>
                                </div>
                                <header>
                                    <h4 class="thin text-muted padding-sm-vertical">TeamDeveloper</h4>
                                </header>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="panel panel-metric panel-metric-sm">
                        <div class="panel-body panel-body-default">
                            <div class="metric-content metric-icon">
                                <div class="value" style="font-size: 17px">
                                    Users: {{$user->sponsors()->count()}}
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <header>
                                    <h4 class="thin text-muted padding-sm-vertical">Member Sponsors</h4>
                                </header>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Turnover: Direct USD</h4>
                        </div>
                        <table class="table table-banded table-condensed table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">Week</th>
                                <th></th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center"> {{formatUSD($turnover->direct_week ?? 0)}}</td>
                                <td class="text-center">{{($auth->product['mlm_direct_bonus'] ?? 0 ) * 100 }} %</td>
                                <td class="text-center">{{formatUSD(($turnover->direct_week ?? 0) * ($auth->product['mlm_direct_bonus'] ?? 0 ))}}</td>
                            </tr>
                            </tbody>
                            <thead>
                            <tr>
                                <th class="text-center">All</th>
                                <th></th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">{{formatUSD($turnover->direct_all ?? 0)}}</td>
                                <th></th>
                                <td class="text-center">{{formatUSD($turnover->direct_total ?? 0)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Turnover: Binary USD</h4>
                        </div>
                        <table class="table table-banded table-condensed table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">Week</th>
                                <th class="text-center"></th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">{{formatUSD($binary_points->left_week)}}
                                    | {{formatUSD($binary_points->right_week)}}</td>
                                <td class="text-center">{{$auth->product['mlm_binary_bonus'] * 100}} %</td>
                                <td class="text-center">{{formatUSD($auth->binary_week)}}</td>
                            </tr>
                            </tbody>
                            <thead>
                            <tr>
                                <th class="text-center">All</th>
                                <th></th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">{{formatUSD($binary_points->left_total)}}
                                    | {{formatUSD($binary_points->right_total)}}</td>
                                <td></td>
                                <td class="text-center">{{formatUSD($auth->binary_total)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">BTC/USD</h4>
                        </div>
                        <div class="">
                            <div class="btcwdgt-chart" style="margin: 0 !important;min-height: 358px"
                                 bw-theme="light"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
@endsection
