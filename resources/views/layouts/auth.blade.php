@extends('layouts.default')
@section('title', $v_lang->title ?? null)
@section('description', $v_lang->description ?? null)

@section('scripts')
    <script src="{{ asset('js/libs.js') }}"></script>
    <script src="https://use.fontawesome.com/dedc421540.js"></script>
    @stack('page-scripts')
@endsection

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    @stack('page-styles')
@endsection

@section('body')
    <div class="login-wrapper">
        <div class="text-center">

            <div class="logo text-center">
                <a href="https://verumtrade.com">
                    <img class="img-responsive logo__img" src="{{asset('img/full-logo.png?=v.1')}}"
                         alt="{{config('app.name')}}">
                </a>
            </div>

        </div>
        <div class="login-widget">
            <div class="panel panel-default">
                @yield('page')
            </div>
        </div>
    </div>
@endsection
