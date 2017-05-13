<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        @section('analytics')
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-99060144-1', 'auto');
                ga('send', 'pageview');

            </script>
        @endsection
        @yield('analytics')
        @section('css')
            <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        @endsection
        @yield('css')
        @section('js')
            <script src="{{ mix('js/app.js') }}"></script>
        @endsection
        @yield('js')

    </head>
    <body>
        <div id="app">
            @include('layouts.header')
            <div class="container content">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </body>
</html>