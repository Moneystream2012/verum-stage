@extends('layouts.default')
@section('title', $v_lang->title ?? null)
@section('description', $v_lang->description ?? null)
@section('body')
    {{-- ========== HEADER ========== --}}
    <header>
        <nav class="navbar navbar-default navbar-static-top no-margin" role="navigation">
            <div class="navbar-brand-group">
                <a class="navbar-sidebar-toggle navbar-link" data-sidebar-toggle>
                    <i class="fa fa-lg fa-fw fa-bars"></i>
                </a>
                <a class="navbar-brand hidden-xs" href="{{route('personal-office.dashboard')}}">
          <span class="sc-visible">
              {{--<h5 style="font-weight: 600;margin: 16px -7px;">M<span style="font-size: 115%;color: #357ebd;">L</span>M</h5>--}}
              <img src="{{asset('img/icon.png?=v.1')}}" class="img-responsive" alt="{{config('app.name')}}">
          </span>
                    <span class="sc-hidden">
                        {{--<h3 style="font-weight: 600">M<span style="font-size: 115%;color: #357ebd;">L</span>M <small>VerumCoin</small></h3>--}}
                        <img src="{{asset('img/logo.png?=v.1')}}" class="img-responsive"
                             alt="{{config('app.name')}}">
					</span>
                </a>
            </div>
            <ul class="nav navbar-nav navbar-nav-expanded pull-right margin-md-right">
                <li class="hidden-xs">
                    <a class="profile-info" href="javascript:;">
                        {{formatUSD($auth->balance)}}
                        <strong class="text-primary">USD</strong>
                        <small class="text-muted">Balance USD</small>
                    </a>
                </li>
                <li class="hidden-xs">
                    <a class="profile-info" href="javascript:;">
                        {{formatVMC($auth->mining_balance)}}
                        <strong class="text-primary">VMC</strong>
                        <span class="text-muted" style="opacity: .5;" > / </span>
                        {{formatUSD(VMCtoUSD($auth->mining_balance))}}
                        <strong class="text-primary">USD</strong>
                        <small class="text-muted">Balance VMC</small>
                    </a>
                </li>
                <li class="hidden-xs">
                    <a class="profile-info" href="javascript:;">
                        {{formatVMC($auth->btc_balance)}}
                        <strong class="text-primary">BTC</strong>
                        <span class="text-muted" style="opacity: .5;" > / </span>
                        {{formatUSD(BTCtoUSD($auth->btc_balance))}}
                        <strong class="text-primary">USD</strong>
                        <small class="text-muted">Balance BTC</small>
                    </a>
                </li>
                {{--<li class="dropdown">--}}
                {{--@php $notifications = $auth->unreadNotifications @endphp--}}
                {{--<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">--}}
                {{--<i class="fa  fa-lg fa-fw fa-bell-o"></i>--}}
                {{--@if($notifications->count() > 0)--}}
                {{--<span--}}
                {{--class="badge badge-up badge-danger badge-small">{{$notifications->count() > 99 ? '99+' : $notifications->count()}}</span>--}}
                {{--@endif--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-notifications pull-right hidden">--}}
                {{--<li class="dropdown-title bg-inverse">Notifications ({{	$notifications->count()}})</li>--}}
                {{--@php $notification_url = route('personal-office.notification') @endphp--}}
                {{--@forelse($notifications as $notification)--}}
                {{--<li>--}}
                {{--<a href="{{$notification->data['link'] ?? $notification_url}}" class="notification">--}}
                {{--<div class="notification-thumb pull-left">--}}
                {{--<i class="fa {{$notification->data['icon']}} fa-2x text-primary"></i>--}}
                {{--</div>--}}
                {{--<div class="notification-body">--}}
                {{--<strong>{{trans('personal-office/notification.'.snake_case(class_basename($notification->type)), $notification->data) }}</strong><br>--}}
                {{--@if($notification->data['text'] ?? false)--}}
                {{--<p class="margin-xs-bottom">{{str_limit($notification->data['text'], 45)}}</p>--}}
                {{--@endif--}}
                {{--<small class="text-muted">{{$notification->created_at->diffForHumans()}}</small>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--@empty--}}
                {{--<p class="text-center small text-muted margin-vertical">Empty</p>--}}
                {{--@endforelse--}}

                {{--<li class="dropdown-footer">--}}
                {{--<a href="{{$notification_url}}"><i class="fa fa-share"></i> See all notifications</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</li>--}}

                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle navbar-user" href="javascript:;">
                        <img class="img-circle"
                             src="{{ $auth->avatar_url }}">
                        <span class="hidden-xs">{{$auth->full_name}}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right pull-right-xs">
                        <li class="arrow"></li>
                        <li><a href="{{route('personal-office.profile')}}">My account</a></li>
                        <li><a href="{{route('personal-office.settings.index')}}"></i>My settings</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('personal-office.logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Log Out
                            </a>
                            <form id="logout-form" action="{{ route('personal-office.logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
    </header>

    {{-- ========== PAGE-WRAPPER ========== --}}
    <div class="page-wrapper">

        {{-- ========== SIDEBAR ========== --}}
        <aside class="sidebar sidebar-default">
            <nav>
                <h5 class="sidebar-header">Navigation</h5>
                <ul class="nav nav-pills nav-stacked">
                    <li class="{{ Route::is('personal-office.dashboard') ? 'active' : '' }}">
                        <a href="{{route('personal-office.dashboard')}}" title="Dashboard">
                            <i class="fa fa-lg fa-fw fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-dropdown {{ Route::is('personal-office.sponsored.binary', 'personal-office.sponsored.unilevel', 'personal-office.sponsored.full') ? 'active open' : '' }}">
                        <a href="#" title="Network">
                            <i class="fa fa-lg fa-fw fa-sitemap"></i> Network
                        </a>
                        <ul class="nav-sub">
                            <li class="{{ Route::is('personal-office.sponsored.binary') ? 'active' : '' }}">
                                <a href="{{route('personal-office.sponsored.binary')}}"
                                   title="@lang('personal-office/sponsored/binary.menu_title')">
                                    <i class="fa fa-fw fa-caret-right"></i> @lang('personal-office/sponsored/binary.menu_title')
                                </a>
                            </li>
                            <li class="{{ Route::is('personal-office.sponsored.unilevel') ? 'active' : '' }}">
                                <a href="{{route('personal-office.sponsored.unilevel')}}"
                                   title="@lang('personal-office/sponsored/unilevel.menu_title')">
                                    <i class="fa fa-fw fa-caret-right"></i> @lang('personal-office/sponsored/unilevel.menu_title')
                                </a>
                            </li>
                            <li class="{{ Route::is('personal-office.sponsored.full') ? 'active' : '' }}">
                                <a href="{{route('personal-office.sponsored.full')}}"
                                   title="@lang('personal-office/sponsored/full.menu_title')">
                                    <i class="fa fa-fw fa-caret-right"></i> @lang('personal-office/sponsored/full.menu_title')
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Route::is('personal-office.posts') ? 'active' : '' }}">
                        <a href="{{route('personal-office.posts')}}" title="@lang('personal-office/posts.title')">
                            <i class="fa fa-fw fa-bullhorn"></i> @lang('personal-office/posts.title')

                            @if($unread_post_count = $auth->unread_post_count)
                                <span class="label label-warning pull-right">{{$unread_post_count}}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-dropdown {{ Route::is('personal-office.ico.telegram') ? 'active open' : '' }}">
                    <a href="#" title="ICO">
                        <i class="fa fa-lg fa-fw fa-globe"></i> ICO
                        <span class="label label-success pull-right">New</span>
                    </a>
                    <ul class="nav-sub">
                        <li class="{{ Route::is('personal-office.ico.telegram') ? 'active' : '' }}">
                            <a href="{{route('personal-office.ico.telegram')}}" title="@lang('personal-office/ico/telegram.title')">
                                <i class="fa fa-fw fa-caret-right"></i> @lang('personal-office/ico/telegram.title')
                            </a>
                        </li>
                    </ul>
                </li>
                    <li class="nav-dropdown {{ Route::is('personal-office.products.deposits.*') ? 'active open' : '' }}">
                        <a href="#" title="Products">
                            <i class="fa fa-lg fa-fw fa-briefcase"></i> Products
                        </a>
                        <ul class="nav-sub">
                            <li class="{{ Route::is('personal-office.products.deposits.usd') ? 'active' : '' }}">
                                <a href="{{route('personal-office.products.deposits.usd')}}">
                                    <i class="fa fa-fw fa-caret-right"></i> Investment Token USD
                                </a>
                            </li>
                            <li class="disabled">
                                <a href="#">
                                    <i class="fa fa-fw fa-caret-right"></i> Investment Token BTC
                                </a>
                            </li>
                            <li class="disabled">
                                <a href="#">
                                    <i class="fa fa-fw fa-caret-right"></i> Investment Token VMC
                                </a>
                            </li>
                            {{--
                            <li class="{{ Route::is('personal-office.products.deposits.usd') ? 'active' : '' }}">
                                <a href="{{route('personal-office.products.deposits.usd')}}">
                                    <i class="fa fa-fw fa-caret-right"></i> @lang('personal-office/products/deposits/usd.menu_title')
                                </a>
                            </li>
                            <li class="{{ Route::is('personal-office.products.deposits.btc') ? 'active' : '' }}">
                                <a href="{{route('personal-office.products.deposits.btc')}}">
                                    <i class="fa fa-fw fa-caret-right"></i> @lang('personal-office/products/deposits/btc.menu_title')
                                </a>
                            </li>
                            <li class="{{ Route::is('personal-office.products.deposits.vmc') ? 'active' : '' }}">
                                <a href="{{route('personal-office.products.deposits.vmc')}}">
                                    <i class="fa fa-fw fa-caret-right"></i> @lang('personal-office/products/deposits/vmc.menu_title')
                                </a>
                            </li>
                            --}}
                        </ul>
                    </li>
                    <li class="{{ Route::is('personal-office.replenishment.index') ? 'active' : '' }}">
                        <a href="{{route('personal-office.replenishment.index')}}" title="Replenishment">
                            <i class="fa fa-fw fa-money"></i> Replenishment
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.balance.withdraw') ? 'active' : '' }}">
                        <a href="{{route('personal-office.balance.withdraw')}}" title="Withdraw">
                            <i class="fa fa-fw fa-btc"></i> Withdraw
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.balance.transfer') ? 'active' : '' }}">
                        <a href="{{route('personal-office.balance.transfer')}}" title="Transfer">
                            <i class="fa fa-fw fa-exchange"></i> Transfer
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.balance.exchange') ? 'active' : '' }}">
                        <a href="{{route('personal-office.balance.exchange')}}" title="Exchange">
                            <i class="fa fa-fw fa-random"></i> Exchange
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.history') ? 'active' : '' }}">
                        <a href="{{route('personal-office.history')}}" title="History">
                            <i class="fa fa-fw fa-history"></i> History
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.marketing') ? 'active' : '' }}">
                        <a href="{{route('personal-office.marketing')}}" title="Affilate program">
                            <i class="fa fa-lg fa-fw fa-book"></i> Affilate program
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.faq') ? 'active' : '' }}">
                        <a href="{{route('personal-office.faq')}}" title="FAQ">
                            <i class="fa fa-lg fa-fw fa-comments-o"></i> FAQ
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.issues.index', 'personal-office.issues.show', 'personal-office.issues.new') ? 'active' : '' }}">
                        <a href="{{route('personal-office.issues.index')}}" title="Support">
                            <i class="fa fa-lg fa-fw fa-comments"></i> Support
                            @if($issues_count = $auth->issues()->where('read', 0)->select('read')->remember(60)->cacheTags('issues_count_'.$auth->id)->count())
                                <span class="label label-warning pull-right">{{$issues_count}}</span>
                            @endif
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.settings.index') ? 'active' : '' }}">
                        <a href="{{route('personal-office.settings.index')}}" title="My Settings">
                            <i class="fa fa-lg fa-fw fa-gears"></i> My Settings
                        </a>
                    </li>
                    <li class="nav-dropdown">
                        <a href="#" title="Promo tools" target="_blank">
                            <i class="fa fa-lg fa-fw fa-download"></i> Promo tools
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a href="{{asset('download/VerumTradeEN.pdf?v=1.1')}}" title="Promo tools EN"
                                   target="_blank">
                                    <i class="fa fa-lg fa-fw fa-file-pdf-o"></i> Promo tools EN
                                </a>
                            </li>
                            <li>
                                <a href="{{asset('download/VerumTradeRU.pdf?v=1.1')}}" title="Promo tools RU"
                                   target="_blank">
                                    <i class="fa fa-lg fa-fw fa-file-pdf-o"></i> Promo tools RU
                                </a>
                            </li>
                            <li>
                                <a href="{{asset('download/VerumTradePL.pdf?v=1.1')}}" title="Promo tools PL"
                                   target="_blank">
                                    <i class="fa fa-lg fa-fw fa-file-pdf-o"></i> Promo tools PL
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown">
                        <a href="#" title="Wallet">
                            <i class="fa fa-lg fa-fw fa-circle-o"></i> Wallet
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a href="https://github.com/verumcoin-project/verumcoin/releases/download/v1.0.0.3/VerumCoin-Qt-macos.zip">
                                    <i class="fa fa-fw fa-caret-right"></i>
                                    MacOs Wallet
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/verumcoin-project/verumcoin/releases/download/v1.0.0.3/VerumCoin-Qt-windows.zip">
                                    <i class="fa fa-fw fa-caret-right"></i>
                                    Windows Wallet
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/verumcoin-project/verumcoin/releases/download/v1.0.0.3/VerumCoin-Qt-linux.zip">
                                    <i class="fa fa-fw fa-caret-right"></i>
                                    Linux Wallet
                                </a>
                            </li>
                            <li>
                                <a href="https://wallet.verumcoin.com/" target="_blank" title="Web Wallet">
                                    <i class="fa fa-fw fa-caret-right"></i>
                                    Web Wallet
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="https://verumcoin.com/" target="_blank" title="VerumCoin">
                            <i class="fa fa-fw fa-check-square-o"></i> VerumCoin
                        </a>
                    </li>
                    <li class="{{ Route::is('personal-office.changelog') ? 'active' : '' }}">
                        <a href="{{route('personal-office.changelog')}}" title="Changelog">
                            <i class="fa fa-lg fa-fw fa-info-circle"></i> Changelog
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- ========== PAGE-CONTENT ========== --}}
        <div class="page-content personal-office">
            <div class="page-subheading page-subheading-md no-margin-bottom bg-whitepage-heading-md">
                <div class="row page-subheading-panel">
                    <div class="col-md-7 col-xs-12 pull-left">
                        {{--<p class="text-muted small margin-xs-bottom">Choose binary side</p>--}}
                        @if($auth->team_developer)
                            @php $leg = $auth->side_leg @endphp

                            <div class="btn-group no-margin-left">
                                <a class="btn btn-round btn-no-border {{$leg ? 'btn-white disabled' : 'btn-primary'}}"
                                   href="{{$url = route('personal-office.settings.binary_side')}}">
                                    <i class="fa fa-user-plus"></i> Left
                                </a>
                                <a class="btn btn-round btn-no-border btn-primary"
                                   href="{{$url}}">
                                    <i class="fa fa-toggle-on fa-rotate{{$leg ?: '-180'}}"></i>
                                </a>
                                <a class="btn btn-round btn-no-border {{!$leg ? 'btn-white disabled' : 'btn-primary'}}"
                                   href="{{$url}}">Right
                                    <i class="fa fa-user-plus"></i>
                                </a>
                            </div>
                        @else
                            <div class="btn-group">
                                <a href="{{route('personal-office.sponsored.new_member')}}"
                                   class="btn btn-round btn-{{!$auth->side_leg ? 'primary' : 'white disabled'}}"><i
                                        class="fa fa-user-plus"></i> Left</a>
                                <a href="{{route('personal-office.sponsored.new_member')}}"
                                   class="btn btn-round btn-{{$auth->side_leg ? 'primary' : 'white disabled'}}">Right <i
                                        class="fa fa-user-plus"></i></a>
                            </div>
                        @endif

                        <a href="{{route('personal-office.sponsored.new_member')}}"
                           class="btn btn-round btn-white new-member"><i
                                class="fa fa-user-plus"></i> New Member</a>

                    </div>
                    <div class="col-md-5 col-xs-12 pull-right">
                        {{--<p class="text-muted small margin-xs-bottom">This is your promotional link</p>--}}

                        <div class="input-group">
                            <span class="input-group-btn">
                                <button data-clipboard-target="#promotional-link" class="btn btn-round btn-white"
                                        type="button">Copy <i
                                        class="fa fa-clipboard"></i></button>
                            </span>
                            <input type="text"
                                   id="promotional-link"
                                   value="{{route('personal-office.sponsor-register', $auth->id) }}"
                                   class="form-control promotional-link" readonly/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid-md no-margin-top">

                @if (!$auth->verified_email)
                    <div class="alert alert-block alert-warning">
                        <p>Please activate your account to start sending emails. We sent an activation email to
                            <i>{{$auth->email}}</i>.
                            <a href="{{route('personal-office.send_activation')}}">Resend activation</a>.
                            {{--<a href="{{route('personal-office.profile')}}">Update email address</a>.--}}
                        </p>
                    </div>
                @endif

                @include('flash::message')

            </div>

            <div class="page-heading page-heading-md">
                <div class="row">
                    <div class="col-sm-8"><h2>{{$v_lang->title or ''}}</h2></div>
                    <div class="col-sm-4">
                        @if(Route::is('personal-office.sponsored.binary', 'personal-office.sponsored.unilevel') )
                            <form action="{{route('personal-office.sponsored.search_user')}}" method="post">
                                {{ Form::token() }}
                                <div class="navbar-search">
                                    <input type="hidden" name="search"
                                           value="{{Route::is('personal-office.sponsored.binary') ? 'binary' : 'unilevel'}}">
                                    <input type="text" name="user" placeholder="Search member id or username..."
                                           class="form-control">
                                    <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        @endif
                        @if(Route::is('personal-office.dashboard'))
                            <div class="text-right" style="padding-top: 4px;font-size: 16px;">
                                 <span class="text-muted">Your rank:</span>  @if($auth->rank >= 2) <i class="fa fa-trophy text-warning"></i> @endif <span class="text-primary">{{$auth->rank_text}}</span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            @yield('page')

        </div>
    </div>
@endsection

@section('scripts')
    <script
        src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
        crossorigin="anonymous"></script>
    <script src="{{asset('veneto/assets/bs3/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('veneto/assets/plugins/jquery-navgoco/jquery.navgoco.js')}}"></script>
    <script src="https://use.fontawesome.com/dedc421540.js"></script>
    <script src="{{asset('veneto/js/main.js')}}"></script>

    @stack('page-scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.16/clipboard.min.js"></script>
    <script>
        new Clipboard('.btn');
    </script>

    <!-- Start SiteHeart code -->
    <script>
        (function(){
            var widget_id = 878873;
            _shcp =[{widget_id : widget_id, auth : @include('include.siteheart_auth', ['auth' => $auth])}];
            var lang = '{{App::getLocale()}}';
            var url ="widget.siteheart.com/widget/sh/"+ widget_id +"/"+ lang +"/widget.js";
            var hcc = document.createElement("script");
            hcc.type ="text/javascript";
            hcc.async =true;
            hcc.src =("https:"== document.location.protocol ?"https":"http")
                +"://"+ url;
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hcc, s.nextSibling);
        })();
    </script>
    <!-- End SiteHeart code -->
@endsection

@section('styles')
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    {{--<link rel="stylesheet" href="{{asset('veneto/css/bootstrap.min.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('veneto/css/veneto-admin.min.css')}}">--}}

    <link rel="stylesheet" href="{{ asset('css/personal-office.css') }}">

    @stack('page-styles')
@endsection
