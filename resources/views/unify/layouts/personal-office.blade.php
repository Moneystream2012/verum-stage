<?php /* @var \App\User $auth; */ ?>
@extends('unify.layouts.default')
@section('title', $v_lang->title)
@section('description', $v_lang->description)
@section('styles')
    <style>
        body,html{margin:0;padding:0}@-webkit-keyframes loading{0%{opacity:0}to{opacity:1}}@keyframes loading{0%{opacity:0}to{opacity:1}}.loading-wrapper{position:fixed;top:0;left:0;background:#f5f6fa;z-index:999999;width:100%;height:100%;overflow:visible;}.loading-wrapper .loading{width:180px;top:50%;margin-top:-23px;text-align:right;left:50%;margin-left:-90px}.loading-wrapper .loading span{top:-12px}.loading-wrapper .loading img{vertical-align:middle;max-width:100%;height:auto;}.loading{position:relative;text-align:center}.loading span{position:relative;display:inline-block;vertical-align:middle;width:9px;height:3px;margin:2px;-webkit-animation:loading 1s infinite alternate;animation:loading 1s infinite alternate}.loading span:first-of-type{background:#65ab53;-webkit-animation-delay:1s;animation-delay:1s}.loading span:nth-of-type(2){background:#4266b2;-webkit-animation-delay:1.1s;animation-delay:1.1s}.loading span:nth-of-type(3){background:#65ab53;-webkit-animation-delay:1.2s;animation-delay:1.2s}.loading span:nth-of-type(4){background:#4266b2;-webkit-animation-delay:1.4s;animation-delay:1.4s}.loading span:nth-of-type(5){background:#65ab53;-webkit-animation-delay:1.6s;animation-delay:1.6s}
    </style>
    <!-- Common CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset_theme('fonts/icomoon/icomoon.css')}}"/>
    <link rel="stylesheet" href="{{mix_theme('css/main.css')}}"/>
    @stack('page-styles')
@endsection
@section('main-heading')
    <div class="input-group">
        <span class="input-group-btn">
            <button data-clipboard-target="#promotional-link" data-toggle="tooltip" data-placement="bottom" data-original-title="{{$l_lang->copy_link}}" class="btn btn-primary" type="button">
                <i class="icon-clipboard2"></i>
            </button>
        </span>
        <input type="text" id="promotional-link"
               value="{{route('personal-office.sponsor-register', $auth->id) }}"
               class="form-control promotional-link" readonly/>
    </div>
@endsection
@section('body')
    <!-- Loading starts -->
    <div class="loading-wrapper">
        <div class="loading">
            <img src="{{asset_theme('img/logo.svg')}}" class="img img-fluid" alt="{{config('app.name')}}">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
    </div>
    <!-- Loading ends -->

    <!-- BEGIN .app-wrap -->
    <div class="app-wrap">
        <!-- BEGIN .app-heading -->
        <header class="app-header">
            <div class="container-fluid">
                <div class="row gutters">
                    <div class="col-2 col-sm-4 col-lg-5">
                        <a class="mini-nav-btn float-left" href="#" id="app-side-mini-toggler">
                            <i class="icon-sort"></i>
                        </a>
                        <a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler float-left"
                           aria-expanded="true">
                            <i class="icon-chevron-thin-left"></i>
                        </a>
                    </div>
                    <div class="col-4 col-sm-4 col-lg-2">
                        <a href="{{route('personal-office.dashboard')}}" class="logo">
                            <img src="{{asset_theme('img/logo.svg')}}" class="img-fluid"
                                 alt="{{config('app.name')}}"/>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-5">
                        <ul class="header-actions">
                            <li class="dropdown">
                                <a href="#" id="userBalances" class="user-balances" data-toggle="dropdown" aria-haspopup="true">
                                    <i class="icon-account_balance text-secondary"></i>
                                    <small class="text-muted text-uppercase desc">{{$l_lang->balance}} </small>
                                    <i class="icon-chevron-small-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right lg" aria-labelledby="userBalances">
                                    <ul class="stats-widget">
                                        <li>
                                            <h5>
                                                {{formatUSD($auth->balance)}}
                                                <small class="text-primary">USD</small>
                                            </h5>
                                            <p>{{$l_lang->balance}} USD</p>
                                        </li>
                                        <li>
                                            <h5>
                                                {{formatVMC($auth->mining_balance)}}
                                                <small class="text-primary">VMC</small>
                                                <span class="text-muted" style="opacity: .5;"> / </span>
                                                {{formatUSD(VMCtoUSD($auth->mining_balance))}}
                                                <small class="text-primary">USD</small>
                                            </h5>
                                            <p>{{$l_lang->balance}} VMC</p>
                                        </li>
                                        @if($auth->cold_balance > 0)
                                        <li>
                                            <h5>
                                                {{formatUSD($auth->cold_balance)}}
                                                <small class="text-primary">USD</small>
                                            </h5>
                                            <p>Cold {{$l_lang->balance}}</p>
                                        </li>
                                        @endif
                                        {{--<li>
                                            <h5>
                                                {{formatVMC($auth->btc_balance)}}
                                                <small class="text-primary">BTC</small>
                                                <span class="text-muted" style="opacity: .5;"> / </span>
                                                {{formatUSD(BTCtoUSD($auth->btc_balance))}}
                                                <small class="text-primary">USD</small>
                                            </h5>
                                            <p>{{$l_lang->balance}} BTC</p>
                                        </li>--}}
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown"
                                   aria-haspopup="true">
                                    <img class="avatar" src="{{$auth->avatar_url}}" alt="{{$auth->full_name}}"/>
                                    <span class="user-name">{{$auth->full_name}}</span>
                                    <i class="icon-chevron-small-down"></i>
                                </a>
                                <div class="dropdown-menu {{--lg--}} dropdown-menu-right" aria-labelledby="userSettings">
                                    <ul class="user-settings-list">
                                        <li>
                                            <a href="{{route('personal-office.profile')}}">
                                                <div class="icon">
                                                    <i class="icon-account_circle"></i>
                                                </div>
                                                <p>@lang('unify/personal-office/profile.title')</p>
                                            </a>
                                        </li>
                                        {{--<li>
                                            <a href="{{route('personal-office.settings.index')}}">
                                                <div class="icon red">
                                                    <i class="icon-cog3"></i>
                                                </div>
                                                <p>@lang('unify/personal-office/settings.title')</p>
                                            </a>
                                        </li>--}}
                                        <li>
                                            <a href="{{route('personal-office.history')}}">
                                                <div class="icon yellow">
                                                    <i class="@lang('unify/personal-office/history.icon')"></i>
                                                </div>
                                                <p>@lang('unify/personal-office/history.title')</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="logout-btn">
                                        <a href="{{ route('personal-office.logout') }}"
                                           class="btn btn-primary"
                                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            {{$l_lang->logout}}
                                        </a>
                                        <form id="logout-form" action="{{ route('personal-office.logout') }}"
                                              method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- END: .app-heading -->
        <!-- BEGIN .app-container -->
        <div class="app-container">
            <!-- BEGIN .app-side -->
            <aside class="app-side" id="app-side">
                <!-- BEGIN .side-content -->
                <div class="side-content ">
                    <!-- BEGIN .user-profile -->
                    <div class="user-profile">
                        <img src="{{$auth->avatar_url}}" class="profile-thumb" alt="{{$auth->full_name}}">
                        <h6 class="profile-name">
                            {{$auth->full_name}}
                            <hr>
                            <small class="text-muted">{{$v_lang->verification}}:</small>
                            <a href="{{route('personal-office.verification.index')}}" class="btn-link text-{{$auth->verified ? 'secondary' : 'warning'}}">{{$auth->verified_status_text}}</a>
                        </h6>

                    </div>
                    <!-- END .user-profile -->
                    <!-- BEGIN .side-nav -->
                    <nav class="side-nav">
                        <!-- BEGIN: side-nav-content -->
                        <ul class="unifyMenu pb-0" id="unifyMenu">
                            <li class="{{ Route::is('personal-office.dashboard') ? 'active selected' : '' }}">
                                <a href="{{route('personal-office.dashboard')}}">
                                    <span class="has-icon">
                                        <i class="@lang('unify/personal-office/dashboard.icon')"></i>
                                    </span>
                                    <span class="nav-title">@lang('unify/personal-office/dashboard.title')</span>
                                </a>
                            </li>
                            <li class="{{ Route::is('personal-office.posts') ? 'active selected' : '' }}">
                                <a href="{{route('personal-office.posts')}}">
                                    <span class="has-icon">
                                        <i class="@lang('unify/personal-office/posts.icon')"></i>
                                    </span>
                                    <span class="nav-title">@lang('unify/personal-office/posts.title')</span>
                                    @if($unread_post_count = $auth->unread_post_count)
                                        <span class="badge badge-secondary badge-pill">{{$unread_post_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="{{ Route::is('personal-office.sponsored.unilevel') ? 'active selected' : '' }}">
                                <a href="{{route('personal-office.sponsored.unilevel')}}">
                                    <span class="has-icon">
                                        <i class="@lang('unify/personal-office/sponsored/unilevel.icon')"></i>
                                    </span>
                                    <span class="nav-title">@lang('unify/personal-office/sponsored/unilevel.title')</span>
                                </a>
                            </li>
                            <li class="{{ $isProducts = Route::is('personal-office.products.deposits.*', 'personal-office.trading.index') ? 'active selected' : '' }}">
                                <a href="#" class="has-arrow" aria-expanded="false">
										<span class="has-icon">
											<i class="{{$l_lang->nav['products']['icon'] ?? null}}"></i>
										</span>
                                    <span class="nav-title">{{$l_lang->nav['products']['title'] ?? null}}</span>
                                </a>
                                <ul aria-expanded="false" class="{{$isProducts ? 'collapse in': ''}}">
                                    <li class="{{ Route::is('personal-office.products.deposits.usd') ? 'current-page' : '' }}">
                                        <a href="{{route('personal-office.products.deposits.usd')}}">
                                            @lang('unify/personal-office/deposits/usd.title')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="btn-link disabled" style="opacity: 0.6">
                                            Investment Token VMC
                                        </a>
                                    </li>
                                    <li class="{{ Route::is('personal-office.trading.index') ? 'current-page' : '' }}">
                                        <a href="{{route('personal-office.trading.index')}}">
                                            @lang('unify/personal-office/trading/index.title')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="btn-link disabled" style="opacity: 0.6">
                                            Mining
                                        </a>
                                    </li>
                                    <li >
                                        <a href="#" class="btn-link disabled" style="opacity: 0.6">
                                            ICO
                                        </a>
                                    </li>
                                    <li >
                                        <a href="#" class="btn-link disabled" style="opacity: 0.6">
                                            Cryptoindex (ETF)
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ $isFinance = Route::is('personal-office.replenishment.index', 'personal-office.finance.*') ? 'active selected' : '' }}">
                                <a href="#" class="has-arrow" aria-expanded="false">
										<span class="has-icon">
											<i class="{{$l_lang->nav['finance']['icon'] ?? null}}"></i>
										</span>
                                    <span class="nav-title">{{$l_lang->nav['finance']['title'] ?? null}}</span>
                                </a>
                                <ul aria-expanded="false" class="{{$isFinance ? 'collapse in': ''}}">
                                    <li class="{{ Route::is('personal-office.replenishment.index') ? 'current-page' : '' }}">
                                        <a href="{{route('personal-office.replenishment.index')}}">
                                            @lang('unify/personal-office/finance/replenishment.title')
                                        </a>
                                    </li>
                                    <li class="{{ Route::is('personal-office.finance.withdraw') ? 'current-page' : '' }}">
                                        <a href="{{route('personal-office.finance.withdraw')}}">
                                            @lang('unify/personal-office/finance/withdraw.title')
                                        </a>
                                    </li>
                                    <li class="{{ Route::is('personal-office.finance.exchange') ? 'current-page' : '' }}">
                                        <a href="{{route('personal-office.finance.exchange')}}">
                                            @lang('unify/personal-office/finance/exchange.title')
                                        </a>
                                    </li>
                                    <li class="{{ Route::is('personal-office.finance.transfer') ? 'current-page' : '' }}">
                                        <a href="{{route('personal-office.finance.transfer')}}">
                                            @lang('unify/personal-office/finance/transfer.title')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ Route::is('personal-office.issues.*') ? 'active selected' : '' }}">
                                <a href="{{route('personal-office.issues.index')}}">
                                    <span class="has-icon">
                                        <i class="@lang('unify/personal-office/issues/index.icon')"></i>
                                    </span>
                                    <span class="nav-title">@lang('unify/personal-office/issues/index.title')</span>
                                    @if($issues_count = $auth->issues()->where('read', 0)->select('read')->remember(60)->cacheTags('issues_count_'.$auth->id)->count())
                                        <span class="badge badge-secondary badge-pill">{{$issues_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="{{ Route::is('personal-office.history') ? 'active selected' : '' }}">
                                <a href="{{route('personal-office.history')}}">
                                    <span class="has-icon">
                                        <i class="@lang('unify/personal-office/history.icon')"></i>
                                    </span>
                                    <span class="nav-title">@lang('unify/personal-office/history.title')</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://verumtrade.com/prisoedinitsja/partneram/" target="_blank">
                                    <span class="has-icon">
                                        <i class="icon-bookmark3"></i>
                                    </span>
                                    <span class="nav-title">Affilate program</span>
                                </a>
                            </li>
                            {{--<li>
                                <a href="#" class="has-arrow" aria-expanded="false">
										<span class="has-icon">
											<i class="icon-download"></i>
										</span>
                                    <span class="nav-title">Promo tools</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li>
                                        <a href="{{asset('download/VerumTradeEN.pdf?v=1.1')}}" target="_blank">
                                            Promo tools EN
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{asset('download/VerumTradeRU.pdf?v=1.1')}}" target="_blank">
                                            Promo tools RU
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{asset('download/VerumTradePL.pdf?v=1.1')}}" target="_blank">
                                            Promo tools PL
                                        </a>
                                    </li>
                                </ul>
                            </li>--}}
                            <li class="{{ Route::is('personal-office.faq') ? 'active selected' : '' }}">
                                <a href="{{route('personal-office.faq')}}">
                                    <span class="has-icon">
                                        <i class="@lang('unify/personal-office/faq.icon')" style="font-size: 0.9em;"></i>
                                    </span>
                                    <span class="nav-title">@lang('unify/personal-office/faq.title')</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="has-arrow" aria-expanded="false">
										<span class="has-icon">
											<i class="icon-link4"></i>
										</span>
                                    <span class="nav-title">VerumCoin</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li>
                                        <a href="http://verumcoin.com" target="_blank">
                                            VerumCoin - Official Site
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://wallet.verumcoin.com" target="_blank">
                                            Web Wallet
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://vmcblockchain.info" target="_blank">
                                            VMC Blockchain
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://github.com/verumcoin-project/verumcoin/releases/download/v1.0.0.3/VerumCoin-Qt-macos.zip" target="_blank">
                                            MacOs Wallet
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://github.com/verumcoin-project/verumcoin/releases/download/v1.0.0.3/VerumCoin-Qt-windows.zip" target="_blank">
                                            Windows Wallet
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://github.com/verumcoin-project/verumcoin/releases/download/v1.0.0.3/VerumCoin-Qt-linux.zip" target="_blank">
                                            Linux Wallet
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- END: side-nav-content -->
                    </nav>
                    <!-- END: .side-nav -->
                </div>
                <!-- END: .side-content -->
            </aside>
            <!-- END: .app-side -->
            <!-- BEGIN .app-main -->
            <div class="app-main">
                <!-- BEGIN .main-heading -->
                <header class="main-heading">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                <div class="page-icon">
                                    <i class="{{$v_lang->icon ?? null}}"></i>
                                </div>
                                <div class="page-title">
                                    <h5>{{$v_lang->title ?? null}}</h5>
                                    <h6 class="sub-heading">{{$v_lang->description ?? null}}</h6>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mt-2 mt-md-0">
                                @yield('main-heading')
                            </div>
                        </div>
                    </div>
                </header>
                <div class="alert-message">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                @include('flash::message')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: .main-heading -->
                <!-- BEGIN .main-content -->
                <div class="main-content">
                    @yield('main-content')
                </div>
                <!-- END: .main-content -->
            </div>
            <!-- END: .app-main -->
        </div>
        <!-- END: .app-container -->
        <!-- BEGIN .main-footer -->
        <footer class="main-footer fixed-btm">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        Copyright <br>
                        {{config('app.name') . ' ' . date('Y')}}
                    </div>
                    {{--<div class="col-6 dropup text-right">
                        <a class="btn btn-link btn-sm btn-outline-light dropdown-toggle" href="#" role="button" id="dropdownMenuLang"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('app.languages.'.(Lang::getLocale()))
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLang">
                            @foreach(trans('app.languages') as $lang=>$name)
                                <a class="dropdown-item" href="?lang={{$lang}}">{{$name}}</a>
                            @endforeach
                        </div>
                    </div>--}}
            </div>
            </div>
        </footer>
        <!-- END: .main-footer -->
    </div>
    <!-- END: .app-wrap -->
@endsection

@section('scripts')
    <!-- jQuery first, then Tether, then other JS. -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{asset_theme('js/tether.min.js')}}"></script>
    <script src="{{asset_theme('vendor/unifyMenu/unifyMenu.js')}}"></script>
    <script src="{{asset_theme('vendor/onoffcanvas/onoffcanvas.js')}}"></script>
    <script src="{{asset_theme('js/moment.js')}}"></script>

    <!-- Slimscroll JS -->
    <script src="{{asset_theme('vendor/slimscroll/slimscroll.min.js')}}"></script>
    <script src="{{asset_theme('vendor/slimscroll/custom-scrollbar.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.16/clipboard.min.js"></script>

    @stack('page-scripts')

    <!-- Common JS -->
    <script src="{{mix_theme('js/common.js')}}"></script>

    <!-- Start SiteHeart code -->
   <script>
        (function () {
            var widget_id = 878873;
            _shcp = [{widget_id: widget_id, auth: @include('include.siteheart_auth', ['auth' => $auth])}];
            var lang = '{{App::getLocale()}}';
            var url = "widget.siteheart.com/widget/sh/" + widget_id + "/" + lang + "/widget.js";
            var hcc = document.createElement("script");
            hcc.type = "text/javascript";
            hcc.async = true;
            hcc.src = ("https:" == document.location.protocol ? "https" : "http")
                + "://" + url;
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hcc, s.nextSibling);
        })();
    </script>
    <!-- End SiteHeart code -->

    <script>
        $(function() {
            $(".loading-wrapper").fadeOut(2000);
        });
    </script>
@endsection

