<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="nav-icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('program') }}">
                    <i class="nav-icon fa fa-code"></i> Programar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('classrooms') }}">
                    <i class="nav-icon fa fa-group"></i> Turmas
                </a>
            </li>

            @role('coach')
                <li class="nav-title">
                    Tutor
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-puzzle"></i> Linguagens
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('languages') }}">
                                <i class="nav-icon icon-puzzle"></i> Todas as Linguagens
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('languages.by-user') }}">
                                <i class="nav-icon icon-puzzle"></i> Minhas Linguagens
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('languages.create') }}">
                                <i class="nav-icon icon-puzzle"></i> Submeter Linguagem
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('coaching') }}">
                        <i class="nav-icon fa fa-group"></i> Turmas
                    </a>
                </li>
            @endrole

            @role('admin')
            <li class="nav-title">
                Administrador
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/log-viewer') }}">
                    <i class="nav-icon fa fa-archive"></i> Logs
                </a>
            </li>
            <li class="divider"></li>
            @endrole
            <li class="nav-item mt-auto">
                <a class="nav-link bg-teal" href="http://github.com" target="_top">
                    <i class="nav-icon fa fa-leanpub"></i> Veja nossos tutoriais
                </a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
