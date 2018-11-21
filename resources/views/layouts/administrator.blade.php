@extends('layouts.default')
@section('body')
    {{-- ========== HEADER ========== --}}
    <header>
        <nav class="navbar navbar-default navbar-static-top no-margin" role="navigation">
            <div class="navbar-brand-group">
                <a class="navbar-sidebar-toggle navbar-link" data-sidebar-toggle>
                    <i class="fa fa-lg fa-fw fa-bars"></i>
                </a>
                <a class="navbar-brand hidden-xxs" href="{{route('administrator.dashboard')}}">
                <span class="sc-visible">
                    <img src="{{asset('img/icon.png')}}" class="img-responsive" alt="{{config('app.name')}}">
                </span>
                    <span class="sc-hidden">
                        <img src="{{asset('img/logo.png')}}" class="img-responsive" alt="{{config('app.name')}}">
                    </span>
                </a>
            </div>
            <ul class="nav navbar-nav navbar-nav-expanded pull-right margin-md-right">
                {{--<li class="dropdown">
                    @php
                        $notifications = $auth->unreadNotifications;
                    @endphp
                    <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                        <i class="fa  fa-lg fa-fw fa-bell-o"></i>
                        @if($notifications->count() > 0)
                            <span class="badge badge-up badge-danger badge-small">{{$notifications->count()}}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-notifications pull-right">
                        <li class="dropdown-title bg-inverse">Notifications ({{	$notifications->count()}})</li>
                        @php $notification_url = route('administrator.notification') @endphp
                        @forelse($notifications as $notification)
                            <li>
                                <a href="{{$notification->data['link'] ?? $notification_url}}" class="notification">
                                    <div class="notification-thumb pull-left">
                                        <i class="fa {{$notification->data['icon']}} fa-2x text-primary"></i>
                                    </div>
                                    <div class="notification-body">
                                        <strong>{{$notification->data['text']}}</strong><br>
                                        <small class="text-muted">{{$notification->created_at->diffForHumans()}}</small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <p class="text-center small text-muted margin-vertical">Empty</p>
                        @endforelse

                        <li class="dropdown-footer">
                            <a href="{{$notification_url}}"><i class="fa fa-share"></i> See all notifications</a>
                        </li>
                    </ul>
                </li>--}}
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle navbar-user" href="javascript:;">
                        <img class="img-circle"
                             src="{{asset('img/avatars/admin.png')}}">
                        <span class="hidden-xs">{{$auth->name}}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right pull-right-xs">
                        <li class="arrow"></li>
                        {{--						<li><a href="{{route('personal-office.profile')}}">My account</a></li>--}}
                        {{--<li><a href="{{route('personal-office.settings')}}"></i>My settings</a></li>--}}
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('administrator.logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Log Out
                            </a>
                            <form id="logout-form" action="{{ route('administrator.logout') }}" method="POST"
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
                    <li class="{{ Route::is('administrator.dashboard') ? 'active' : '' }}">
                        <a href="{{route('administrator.dashboard')}}">
                            <i class="fa fa-lg fa-fw fa-dashboard"></i> Dashboard
                        </a>
                    </li>

                    <li class="{{ Route::is('administrator.users.index') ? 'active' : '' }}">
                        <a href="{{route('administrator.users.index')}}">
                            <i class="fa fa-lg fa-fw fa-users"></i> Пользователи
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.replenishments.index') ? 'active' : '' }}">
                        <a href="{{route('administrator.replenishments.index')}}">
                            <i class="fa fa-lg fa-fw fa-mail-forward"></i> Пополнения
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.withdraws.index') ? 'active' : '' }}">
                        <a href="{{route('administrator.withdraws.index')}}">
                            <i class="fa fa-lg fa-fw fa-mail-reply"></i> Выводы
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.ico.index') ? 'active' : '' }}">
                        <a href="{{route('administrator.ico.index')}}">
                            <i class="fa fa-lg fa-fw fa-globe"></i> ICO
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.deposits.index', 'administrator.deposits.update') ? 'active' : '' }}">
                        <a href="{{route('administrator.deposits.index')}}">
                            <i class="fa fa-lg fa-fw fa-briefcase"></i> Пакеты
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.trading.index', 'administrator.deposits.update') ? 'active' : '' }}">
                        <a href="{{route('administrator.trading.index')}}">
                            <i class="fa fa-lg fa-fw fa-briefcase"></i> Trading
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.transfers.index') ? 'active' : '' }}">
                        <a href="{{route('administrator.transfers.index')}}">
                            <i class="fa fa-lg fa-fw fa-exchange"></i> Переводы
                        </a>
                    </li>

                    <li class="{{ Route::is('administrator.exchanges.index') ? 'active' : '' }}">
                         <a href="{{route('administrator.exchanges.index')}}">
                             <i class="fa fa-lg fa-fw fa-random"></i> Обмены
                         </a>
                     </li>

                    <li class="{{ Route::is('administrator.issues.index', 'administrator.issues.show', 'administrator.issues.new') ? 'active' : '' }}">
                        <a href="{{route('administrator.issues.index')}}">
                            <i class="fa fa-lg fa-fw fa-comments"></i> Техподдержка
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.settings.index') ? 'active' : '' }}">
                        <a href="{{route('administrator.settings.index')}}">
                            <i class="fa fa-lg fa-fw fa-gears"></i> Settings
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.changelog.index', 'administrator.changelog.add') ? 'active' : '' }}">
                        <a href="{{route('administrator.changelog.index')}}">
                            <i class="fa fa-lg fa-fw fa-info-circle"></i> Changelog
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.posts.*') ? 'active' : '' }}">
                        <a href="{{route('administrator.posts.index')}}" title="News">
                            <i class="fa fa-lg fa-fw fa-bullhorn"></i> News
                        </a>
                    </li>
                    <li class="{{ Route::is('administrator.verifications.*') ? 'active' : '' }}">
                        <a href="{{route('administrator.verifications.index')}}">
                            <i class="fa fa-lg fa-fw fa-lock"></i> Верификация
                        </a>
                    </li>
                    <li>
                        <a href="{{route('personal-office.dashboard')}}" title="Backoffice" target="_blank">
                            <i class="fa fa-lg fa-fw fa-circle-o"></i> Backoffice
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- ========== PAGE-CONTENT ========== --}}
        <div class="page-content personal-office">
            <div class="page-subheading page-subheading-md no-margin-bottom bg-whitepage-heading-md">
                <div class="row">

                </div>
            </div>

            <div class="container-fluid-md no-margin-top">
                @include('flash::message')
            </div>

            <div class="page-heading page-heading-md">
                <div class="row">
                    <div class="col-sm-8"><h2>@yield('title', 'Not Title')</h2></div>
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
@endsection

@section('styles')
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    {{--<link rel="stylesheet" href="{{asset('veneto/css/bootstrap.min.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('veneto/css/veneto-admin.min.css')}}">--}}

    <link rel="stylesheet" href="{{ asset('css/personal-office.css') }}">

    @stack('page-styles')
@endsection
