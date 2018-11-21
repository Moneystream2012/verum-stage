<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="utf-8">
    <title>{{config('app.name')}} {{Route::is('home') ? '-' : '|'}} @yield('title', trans('app.subtitle'))</title>

    <meta name="description" content="@yield('description', trans('app.description'))">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    {{--<link rel="apple-touch-icon" href="{{asset('img/favicon/apple-touch-icon.png')}}">--}}
    {{--<link rel="apple-touch-icon" sizes="72x72" href="{{asset('img/favicon/apple-touch-icon-72x72.png')}}">--}}
    {{--<link rel="apple-touch-icon" sizes="114x114" href="{{asset('img/favicon/apple-touch-icon-114x114.png')}}">--}}
    @yield('styles')
</head>
<body>
@yield('body')

<!--[if lt IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

{{--<script src="{{asset('js/laroute.js')}}"></script>--}}

@yield('scripts')

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-103239849-1', 'auto');
    ga('send', 'pageview');

</script>

</body>
</html>
