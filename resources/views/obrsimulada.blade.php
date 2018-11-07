<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Weduc</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .downloads .download {
            margin: 20px 0 20px;
            float: left;
        }

        .alt-downloads.download-buttons.swimlane {
            padding-bottom: 2rem;
        }

        .alt-downloads .logo {
            height: 100px;
            width: 100px;
            background-size: contain !important;
            margin: 0 auto;
            -ms-high-contrast-adjust: none;
        }

        .alt-downloads .logo.windows {
            background: url({{ asset('/images/windows-logo.png') }}) center center no-repeat;
        }

        .alt-downloads .logo.mac {
            background: url({{ asset('/images/apple-logo.svg') }}) center center no-repeat;
        }

        .alt-downloads .link-button {
            color: white;
            margin: 20px 0 5px;
            padding: 10px 0;
            font-size: 1.8rem;
            width: 240px;
            background-color: #0b0077;
        }

        .dlink {
            cursor: pointer;
        }

        .alt-downloads .link-button img {
            position: relative;
            top: -2px;
            margin-right: 10px;
        }

        .alt-downloads .link-button small {
            display: block;
            margin-top: 0.75rem;
            color: rgba(255,255,255,0.65);
            font-size: 1.2rem;
        }

    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Cadastro</a>
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            OBR Simulada
        </div>
        <div class="alt-downloads">
            <div class="download">
                <div class="logo windows"></div>
                <button class="link-button dlink" data-os="win" aria-label="Windows download" role="link" onclick="downloadWindows()">
                    <img class="download-icon" src="{{ asset('/images/download.svg') }}" width="18px" height="18px" alt="Download VS Code"> Windows
                    <small>Windows 7, 8, 10</small>
                </button>
            </div>
            <div class="download">
                <div class="logo mac"></div>
                <button class="link-button dlink" data-os="osx" aria-label="Mac download" role="link" onclick="downloadMac()">
                    <img class="download-icon" src="{{ asset('/images/download.svg') }}" width="18px" height="18px" alt="Download VS Code"> Mac
                    <small>macOS 10.9+</small></button>
            </div>
        </div>
    </div>
</div>
<script>
    function downloadWindows() {
        window.open('http://bit.ly/obr_simulada_windows', '_blank');
    }
    function downloadMac() {
        window.open('http://bit.ly/obr_simulada_OSX', '_blank');
    }
</script>
</body>
</html>
