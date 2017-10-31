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
    <link href="/css/sweetalert2.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @stack('scripts')
</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'                  - Fixed Header

// Brand options
1. '.brand-minimized'       - Minimized brand (Only symbol)

// Sidebar options
1. '.sidebar-fixed'                 - Fixed Sidebar
2. '.sidebar-hidden'                - Hidden Sidebar
3. '.sidebar-off-canvas'        - Off Canvas Sidebar
4. '.sidebar-minimized'         - Minimized Sidebar (Only icons)
5. '.sidebar-compact'             - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'          - Fixed Aside Menu
2. '.aside-menu-hidden'         - Hidden Aside Menu
3. '.aside-menu-off-canvas' - Off Canvas Aside Menu

// Breadcrumb options
1. '.breadcrumb-fixed'          - Fixed Breadcrumb

// Footer options
1. '.footer-fixed'                  - Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
        @include('parts.header')

        <div class="app-body">
            @include('parts.sidebar')

            <!-- Main content -->
            <main class="main">

                @yield('content')
            </main>

            @include('parts.aside')


        </div>

        @include('parts.footer')
    </div>

    <!-- Bootstrap and necessary plugins -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="/js/sweetalert2.min.js"></script>


    <!-- Plugins and scripts required by all views -->
    {{-- <script src="node_modules/chart.js/dist/Chart.min.js"></script> --}}
    <script src="http://coreui.io/demo/Static_Demo/vendors/js/Chart.min.js"></script>


    <!-- Plugins and scripts required by this views -->


    <!-- Custom scripts required by this view -->
    {{-- <script src="js/views/main.js"></script> --}}
    @stack('bottom-scripts')

</body>

</html>
