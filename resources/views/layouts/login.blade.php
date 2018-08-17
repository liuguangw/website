<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
    <!-- CSRF Token -->
    <script type="text/javascript">
        window.app_csrf="{{ csrf_token() }}";
    </script>
    <title>@yield('title', 'bbs login page')</title>
</head>
<body>
@yield('content')
@yield('scripts','')
</body>
</html>
