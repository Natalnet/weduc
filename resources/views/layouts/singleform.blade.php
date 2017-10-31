<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="{{ config('app.description', 'An example app') }}">
    <meta name="author" content="{{ config('app.author', 'John Doe') }}">
    <meta name="keyword" content="{{ config('app.keyword', 'Laravel') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="img/favicon.png">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Main styles for this application -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @stack('scripts')
</head>

<body class="app flex-row align-items-center">
    <div class="container" id="app">
        @yield('content')
    </div>

    <!-- Bootstrap and necessary plugins -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('bottom-scripts')

</body>

</html>
