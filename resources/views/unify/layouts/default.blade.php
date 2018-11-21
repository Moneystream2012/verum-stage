<!doctype html>
<html lang="{{App::getLocale()}}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="@yield('description', trans('app.description'))">
        <meta name="keywords" content="@yield('keywords', trans('app.keywords'))" />
        <meta name="author" content="{{config('app.name')}}" />
        <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
        <title>{{config('app.name')}} {{Route::is('home') ? '-' : '|'}} @yield('title', trans('app.subtitle'))</title>

        @yield('styles')
    </head>
    <body>
        @yield('body')

        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

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
