@extends('layouts.administrator')
@section('title', 'Dashboard')
@push('page-styles')
    <style>
        .panel-metric-sm .metric-content{
            min-height: 125px;
        }

        .panel-metric-sm .metric-content .value{
            min-height: 73px;
            /*line-height: 73px;*/
        }
    </style>
@endpush
@section('page')

	<div class="container-fluid-md">
		<div class="row">

			<div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
								{{$data->users['count']}}
							</div>
							<div class="icon">
								<i class="fa fa-users"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Users</h4>
							</header>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_usd($data->users['balance_usd']) <br>
                                @format_vmc($data->users['balance_vmc'])
							</div>
							<div class="icon">
								<i class="fa fa-dollar"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">USD Balance</h4>
							</header>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_vmc($data->users['mining_balance_vmc'])<br>
                                @format_usd($data->users['mining_balance_usd'])
							</div>
							<div class="icon">
								<i class="fa fa-dollar"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">VMC Balance</h4>
							</header>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_usd($data->commissions_usd ?? 0)<br>
                                @format_btc($data->commissions_btc ?? 0)<br>
                                @format_vmc($data->commissions_vmc ?? 0)<br>
							</div>
							<div class="icon">
								<i class="fa fa-dollar"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Commissions</h4>
							</header>
						</div>
					</div>
				</div>
			</div>
            <div class="col-sm-6 col-lg-4">
                <div class="panel panel-metric panel-metric-sm">
                    <div class="panel-body panel-body-default">
                        <div class="metric-content metric-icon">
                            <div class="value">
                                @format_usd($data->computes['binary'])
                            </div>
                            <div class="icon">
                                <i class="fa fa-usd"></i>
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Rewards: Binary Bonus</h4>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="panel panel-metric panel-metric-sm">
                    <div class="panel-body panel-body-default">
                        <div class="metric-content metric-icon">
                            <div class="value">
                                @format_usd($data->computes['direct'])
                            </div>
                            <div class="icon">
                                <i class="fa fa-usd"></i>
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Rewards: Direct Bonus</h4>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_usd($data->deposits['amount'])
							</div>
							<div class="icon">
								<i class="fa fa-briefcase"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Investment Token</h4>
							</header>
						</div>
					</div>
				</div>
			</div>
            <div class="col-sm-6 col-lg-4">
                <div class="panel panel-metric panel-metric-sm">
                    <div class="panel-body panel-body-default">
                        <div class="metric-content metric-icon">
                            <div class="value">
                                @format_usd($data->deposits['cold_balance'])
                            </div>
                            <div class="icon">
                                <i class="fa fa-briefcase"></i>
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Cold deposits balance</h4>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_usd($data->rewards['deposit'])
							</div>
							<div class="icon">
								<i class="fa fa-briefcase"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Payouts: Investment Token</h4>
							</header>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_usd($data->remains['payout_deposits_all'])
							</div>
							<div class="icon">
								<i class="fa fa-briefcase"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Remains payout: Investment Token</h4>
							</header>
						</div>
					</div>
				</div>
			</div><div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_usd($data->remains['payout_deposits_personal'])
							</div>
							<div class="icon">
								<i class="fa fa-briefcase"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Remains payout of personal: <br> Investment Token</h4>
							</header>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value" style="height: 200px;">
								@format_usd($data->replenishments['amount']['usd'] ?? 0)<br>
								@format_btc($data->replenishments['amount']['btc'] ?? 0)<br>
								@format_vmc($data->replenishments['amount']['vmc'] ?? 0)<br>
							</div>
							<div class="icon">
								<i class="fa fa-mail-forward"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Replenishments</h4>
							</header>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_usd($data->withdraws['amount_success'])
							</div>
							<div class="icon">
								<i class="fa fa-mail-reply"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Withdraws: Success</h4>
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
                                BTC => @format_usd($data->withdraws['amount_processing']['BTC'] ?? 0) <br>
                                {{--<small class="text-muted">(@format_btc(USDtoBTC( $data->withdraws['amount_processing']['BTC'] ?? 0)))</small>--}}
                                <hr class="no-margin">
                                VMC => @format_usd($data->withdraws['amount_processing']['VMC'] ?? 0) <br>
                                <small class="text-muted">(@format_vmc(USDtoVMC($data->withdraws['amount_processing']['VMC'] ?? 0)))</small>
							</div>
							<div class="icon">
								<i class="fa fa-repeat"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Withdraws: Processing</h4>
							</header>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<div class="value">
                                @format_usd($data->ico['amount']['telegram'] ?? 0)
							</div>
							<div class="icon">
								<i class="fa fa-globe"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">ICO Telegram</h4>
							</header>
						</div>
					</div>
				</div>
			</div>
            <div class="col-sm-6 col-lg-4">
				<div class="panel panel-metric panel-metric-sm">
					<div class="panel-body panel-body-default">
						<div class="metric-content metric-icon">
							<h3 class="value">
                                <small>Invest:</small> @format_usd($data->trading['invest'] ?? 0) <br>
                                <small>Profit:</small> @format_usd($data->trading['profit'] ?? 0) <br>
                                <small>Percent:</small> <a href="{{route('administrator.trading.update')}}">{{$data->trading['percent']}} %</a>
							</h3>
							<div class="icon">
								<i class="fa fa-briefcase"></i>
							</div>
							<header>
								<h4 class="thin text-muted padding-sm-vertical">Trading</h4>
							</header>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

