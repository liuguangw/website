<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css"/>
@yield('styles','')
<!-- CSRF Token -->
    <script type="text/javascript">
        window.app_csrf = "{{ csrf_token() }}";
    </script>
    <title>@yield('title', 'forum')</title>
</head>
<body>
<div class="site-header">
    <div class="site-warp">
        <p>header</p>
    </div>
</div>
<div class="site-warp">
    @yield('content')
</div>
@yield('scripts','')
</body>
</html>
