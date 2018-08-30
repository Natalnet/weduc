<header class="app-header navbar">
    {{--<button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">☰</button>--}}
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
{{--    <a class="navbar-brand text-center" href="{{ route('home') }}" style="background-image: none;">Weduc</a>--}}
    <a class="navbar-brand" href="{{ route('home') }}">
        {{--<img class="navbar-brand-full" src="img/brand/logo.svg" width="89" height="25" alt="Weduc">--}}
        {{--<img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="Weduc">--}}
        Weduc
    </a>
    {{--<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">☰</button>--}}
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
        @hasrole('admin')
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('users.index') }}">Usuários</a>
        </li>
        @endhasrole
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('register') }}">Registrar</a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000" class="img-avatar" alt="{{ Auth::user()->name }}">
                    <span class="d-md-down-none">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Settings</strong>
                    </div>
                    <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Perfil</a>
                    <div class="divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        <i class="fa fa-lock"></i> Sair
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        @endguest
    </ul>
    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </button>

</header>
