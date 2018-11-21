@extends('layouts.personal-office')
@push('page-scripts')
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script>
        $(".money").maskMoney({thousands: '', decimal: '.'});
    </script>
@endpush
@push('page-styles')
    {!! Charts::styles() !!}
    <style>
        .indent {
            text-indent: 15px;
        }
    </style>
@endpush
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a data-toggle="tab" href="#tab-en">English</a></li>
                        <li><a data-toggle="tab" href="#tab-ru">Russian</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-en" class="tab-pane active">
                            <p>Dear Partners,<br> The management of the company decided to give all of  you the opportunity to participate in the most top-end ICO projects, where there is a large threshold of entry. Usually such ICO is completely closed by large companies and funds. The company performs as a pool, collects the necessary amount and invests in the ICO project, with which it enters into an official agreement and after receiving and defrosting the tokens, distributes them among investors in the corresponding amount.</p>
                            <p class="indent">All of you, probably heard about ICO TON (Telegram Open Network). Today, it is the biggest ІСО in the history of mankind! Our team of analysts presumes very high expectations and profit from this project! A few days later, the second token sale closes, in which each of you can still take part! The company takes part in both the second and third token sales. Until March 6, you can still enter the second sale and join the company's pool of $ 10,000,000 with an amount of 5,000 from one investor! The estimated price of the token on the second token is 1.33. According to preliminary data at the third sale, the price of the token will start from $ 2.20</p>
                            <p class="indent">For all the large investors and funds that participated in the first sale of the tokens there is Lockup (the commitment not to sell tokens) for 18 months. In the second sale there are no Lockup tokens.</p>
                            <p class="indent">All the tokens that the investor buys will be displayed in his personal account. After defrosting the tokens by the project itself (TON), investors can optionally sell their tokens at a market price or withdraw them to an external purse minus the commission. Before defrosting the tokens, investors will be able to sell their tokens to a new partner of the company via internal transfer, by coordinating it with the company's management. That means, if you bought tokens today at 1.33 and a month later the price of the token is already 2.2, then you can sell them to a new partner at a market price within the company.</p>
                            <p>This function will make it possible to fix the profit to the investor in a short time, which  can be measured in several tens of percent in a month.</p>
                            <b>The terms of participation:</b>
                            <ol>
                                <li>When buying tokens, the charge for service, support, documentation is -26%</li>
                                <li>Service per year is 2%</li>
                                <li>After  the release of tokens on the exchange when they are sold -30%</li>
                            </ol>
                            <p>Starting from the project's road map, the purchased tokens will be available for sale on the exchange in December.</p>
                            <p>According to the most conservative forecasts, the price of the token upon withdrawal will be $ 8-12. Similarly, analysts predict $ 80-100 for a token in the short time period.</p>
                            <b>Affiliate program</b>
                            <p>Bonuses and rewards for the affiliate program are calculated in the same way, but with each purchase of tokens, 50% of your investments are credited to your team.</p>
                            <a href="{{asset('download/TON.pdf')}}" title="White paper TON" style="font-size: 32px" class="thin" target="_blank">
                                <i class="fa fa-fw fa-download"></i> White paper TON</a>
                        </div>
                        <div id="tab-ru" class="tab-pane">
                            <p>Дорогие партнеры,<br> руководство компании приняло решение давать Вам всем возможность по желанию принимать участие в самых топовых ICO проектах, где большой порог входа. Обычно такие ICO полностью закрывают большие компании и фонды. Компания выступает в качевсте фонда, собирает нужную сумму и инвестирует средства в ICO проект, с которым заключает оффициальный договор и после получения и разморозки токенов расспределяет их между инвесторами в соответствующем количестве!</p>
                            <p class="indent">Все Вы наверное слышали об ICO TON (Telegram Open Network). На сегодня это уже самое больше ІСО в истории человечевства! Наша команда аналитиков полагает очень большие ожидания и прибыль от этого проекта! Через несколько дней закрывается второй токен сейл, в котором каждий из Вас еще может принять участие! Компания принимает участие как во втором так и в третьем токен сейле. До 6-го марта можно еще войти во вторую расспродажу и присоединиться к пулу компании в 10 000 000 долларов с суммой от 5 000 от одного инвестора! Примерная цена токена на втором токен сейле 1.33. По предварительным данным на третьей распродаже цена токета будет стартовать от 2.20$</p>
                            <p class="indent">Для всех крупных инвесторов и фондов, которые участвовали в первой распродаже токенов есть Lockup (обязательство не продавать токены) на 18 месяцев. Во второй распродаже токенов Lockup нет.</p>
                            <p class="indent">Все токены, которые покупает инвестор будут отображаться в его личном кабинете. После разморозки токенов самим проектом (TON), инвесторы по желанию смогут продать свои токены по рыночной цене или вывести их на внешний кошелек за вычетом коммисии.</p>
                            <p class="indent">До разморозки токенов в инвесторов по желанию будет возможность продать свои токены новому партнеру компании через внутреный перевод, согласуя это с руководсвом компании. Тоесть, если Вы купили сегодня токены по 1.33 и через месяц цена токена уже 2.2 то Вы сможете продать их новому партнеру по рыночной цене внутри компании.</p>
                            <p>Эта функция даст возможность в краткие сроки зафиксировать прибыль инвестору, которая уже через месяц может измеряться в нескольких десятках процентов.</p>
                            <b>Условия участия:</b>
                            <ol>
                                <li>При покупке токенов взымается оплата за услугу, сопровождение, документацию -26%</li>
                                <li>Обслуживание 2% в год</li>
                                <li>После выхода токенов на биржу при их продаже  -30%</li>
                            </ol>
                            <p>Отталкиваясь от дорожной карты проекта в декабре купленные токены будут доступны к продаже на бирже.</p>
                            <p>По самым скромным прогнозам цена токена при выходе составит 8-12$. Так же аналитики прогнозируют 80-100$ за токен в краткосрочной перспективе.</p>
                            <b>Партнерская программа</b>
                            <p>Бонусы и вознаграждения по партнерской программе начисляются так же, но с каждой покупки токенов в Вашу команду зачисляется 50% от сделаных инвестиций.</p>
                            <a href="{{asset('download/TON.pdf')}}" title="White paper TON" style="font-size: 32px" class="thin" target="_blank">
                                <i class="fa fa-fw fa-download"></i> White paper TON</a>
                        </div>
                        @if($chart_enable)
                            <hr>
                            <div class="margin-top">
                                <center>
                                    <h3><i class="fa fa-send" style="color: #0088cc;"></i> ICO Telegram</h3>
                                    {!! $chart->html() !!}
                                </center>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-metric panel-metric-sm">
                    <div class="panel-body panel-body-default">
                        <div class="metric-content metric-icon">
                            <div class="value">
                                @format_usd($amount_invest)
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">All Amount Invest</h4>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-metric panel-metric-sm">
                    <div class="panel-body panel-body-default">
                        <div class="metric-content metric-icon">
                            <div class="value">
                                Processing
                            </div>
                            <header>
                                <h4 class="thin text-muted padding-sm-vertical">Tokens</h4>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">New Investment</h3>
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="alert alert-no-border alert-warning">
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Min Amount</strong> <br>
                            @format_usd(5000)
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{Form::open(['route'=> 'personal-office.ico.invest.post'])}}
                    <input type="hidden" name="ico_type" value="telegram">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="amount" class="control-label">Amount USD</label>
                            <input type="text" class="form-control money" placeholder="0.00" name="amount"
                                   autocomplete="off" required/>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Payment Method</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">Select an Option</option>
                                <option value="balance">Balance USD</option>
                                <option value="mining_balance">Balance VMC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-primary disabled" type="submit">Invest</button>
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
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>@format_usd($item->amount)</td>
                                <td>{{$item->method}}</td>
                                <td>@format_date($item->created_at)</td>
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
