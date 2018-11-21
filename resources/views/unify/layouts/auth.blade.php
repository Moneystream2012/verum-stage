@extends('layouts.default')
@section('title', $v_lang->title ?? null)
@section('description', $v_lang->description ?? null)

@section('scripts')
    <script src="{{ asset('js/libs.js') }}"></script>
    <script src="https://use.fontawesome.com/dedc421540.js"></script>
    @stack('page-scripts')
@endsection

@section('styles')
    <link href="{{ mix('css/auth.css') }}" rel="stylesheet">
    @stack('page-styles')
@endsection

@section('body')
    <div class="login-wrapper">
        <div class="logo">
            <a href="https://verumtrade.com" class="logo_link">
                <img class="logo__img" src="{{asset_theme('img/full-logo.svg')}}"
                     alt="{{config('app.name')}}">
            </a>
        </div>
        <div class="login-widget">
            <div class="panel panel-default">
                @yield('page')
            </div>
        </div>
    </div>
@endsection
