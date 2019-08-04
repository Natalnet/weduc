<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('program') }}">
                    <i class="nav-icon fa fa-code"></i> Programar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('classrooms') }}">
                    <i class="nav-icon fas fa-users"></i> Turmas
                </a>
            </li>

            @role('coach')
                <li class="nav-title">
                    Tutor
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon fas fa-puzzle-piece"></i> Linguagens
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('languages') }}">
                                <i class="nav-icon fas fa-puzzle-piece"></i> Todas as Linguagens
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('languages.by-user') }}">
                                <i class="nav-icon fas fa-puzzle-piece"></i> Minhas Linguagens
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('languages.create') }}">
                                <i class="nav-icon fas fa-puzzle-piece"></i> Submeter Linguagem
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('coaching') }}">
                        <i class="nav-icon fas fa-users"></i> Turmas
                    </a>
                </li>
            @endrole

            @role('admin')
            <li class="nav-title">
                Administrador
            </li>
            <li class="divider"></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/log-viewer') }}">
                    <i class="nav-icon fas fa-archive"></i> Logs
                </a>
            </li>
            <li class="divider"></li>
            @endrole
            <li class="nav-item mt-auto">
                <a class="nav-link bg-teal" href="https://github.com/Natalnet/relex/wiki/Tutorial-da-Linguagem-R-Educ" target="_blank">
                    <i class="nav-icon fas fa-book-open"></i> Veja nossos tutoriais
                </a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
