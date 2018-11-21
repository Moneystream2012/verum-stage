@extends('layouts.personal-office')
@push('page-styles')
    {!! Charts::styles() !!}
@endpush

@push('page-scripts')
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}

    <script>
        (function (b, i, t, C, O, I, N) {
            window.addEventListener('load', function () {
                if (b.getElementById(C)) return;
                I = b.createElement(i), N = b.getElementsByTagName(i)[0];
                I.src = t;
                I.id = C;
                N.parentNode.insertBefore(I, N);
            }, false)
        })(document, 'script', 'https://widgets.bitcoin.com/widget.js', 'btcwdgt');
        jQuery.noConflict();
        $( document ).ready(function() {
            $('#flash-overlay-modal').modal();
        });
    </script>
@endpush

@section('page')
    <div class="container-fluid-md">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="panel panel-metric panel-metric-sm">
                    <div class="panel-body panel-body-default">
                        <div class="metric-content metric-icon">
                            <div class="value" style="font-size: 17px">
                                {{formatUSD($auth->balance)}} USD
                                {{--<strong class="text-primary">USD</strong>--}}
                                <br>
                                {{--{{formatUSD(VMCtoUSD($auth->mining_balance))}} USD--}}
                                {{--<strong class="text-primary">USD</strong>--}}
                                {{--<span class="text-muted" style="opacity: .5;"> / </span>--}}
                                {{--{{formatVMC($auth->mining_balance)}} VMC--}}
                                {{--<strong class="text-muted">VMC</strong>--}}
                                {{--<small class="text-muted"></small>--}}
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Balance USD
                                </h4>
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
                                {{formatVMC($auth->mining_balance)}} VMC
                                <br>
                                {{formatUSD(VMCtoUSD($auth->mining_balance))}} USD
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Balance VMC</h4>
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
                                {{formatVMC($auth->btc_balance)}} BTC
                                <br>
                                {{formatUSD(BTCtoUSD($auth->btc_balance))}} USD
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Balance BTC</h4>
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
                                {{$auth->product['name']}} <br>
                                all:  {{$count['deposit']}}
                            </div>
                            <div class="icon">
                                <i class="fa fa-suitcase"></i>
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Plan</h4>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="panel panel-metric panel-metric-sm">
                    <div class="panel-body panel-body-default">
                        <div class="metric-content metric-icon">
                            <div class="value" style="font-size: 17px; margin-right: 15px">
                                {{$next_rank['text_rank']}} <br>
                                <small>@format_usd($next_rank['reward'])</small>
                            </div>
                            <div class="icon">
                                <span class="text-muted">Turnover Binary:</span> {{formatUSD($next_rank['binary'])}} <br>
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
            <div class="col-sm-6 col-lg-4">
                <div class="panel panel-metric panel-metric-sm">
                    <div class="panel-body panel-body-default">
                        <div class="metric-content metric-icon">
                            <div class="value" style="font-size: 17px">
                                @format_usd($all_bonus)
                            </div>
                            <div class="icon">
                                <i class="fa fa-gift"></i>
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Overall Bonus</h4>
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
                                @format_usd($matching_bonus)
                            </div>
                            <div class="icon">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Matching Bonus</h4>
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">VMC/USD</h4>
                    </div>
                    <div class="panel-body panel-body-primary text-white" style="padding: 8px 15px">
                        <h3 title="VerumCoin price " class="no-margin">
                            $ {{formatUSD(config('mlm.currencies.VMC.USD'))}}
                        </h3>
                        <span style="padding-top: 1px;display: block">VMC/USD</span>
                    </div>

                    <div class="">

                        {!! $chart->html() !!}
                    </div>
                </div>
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
@endsection
