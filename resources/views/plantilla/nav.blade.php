<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Imperial Suites - Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('perfil.pedidos') }}">Pedidos</a></li>
                @canany(['user-list', 'rol-list'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownSeguridad" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Seguridad</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownSeguridad">
                        @can('user-list')
                        <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                        @endcan
                        @can('rol-list')
                        <li><a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @canany(['producto-list'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownAlmacen" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Almacén</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAlmacen">
                        @can('producto-list')
                        <li><a class="dropdown-item" href="{{ route('productos.index') }}">Productos</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @if(Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }}</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                        <li><a class="dropdown-item" href="{{ route('perfil.edit') }}">Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                            <form action="{{ route('logout') }}" id="logout-form" method="post" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>