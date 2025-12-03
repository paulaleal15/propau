<nav class="navbar navbar-expand-lg navbar-light bg-imsu">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#!">Imperialsuites.com</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Conocenos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('web.habitaciones') }}">Habitaciones</a></li>

                <li class="nav-item dropdown">
                    @auth
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.calendario-reservas') }}">Calendario de reservas</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.gestion-reservas') }}">Gestion de reservas</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.inventario-tarifas') }}">Inventario y tarifas</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reporte-analisis') }}">Reporte y analisis</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                            <form action="{{ route('logout') }}" id="logout-form" method="post" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                    @endauth
                </li>

            </ul>
            <a href="{{route('carrito.mostrar')}}" class="btn btn-outline-dark">
                <i class=""></i>
                Reservar

            </a>
        </div>
    </div>
</nav>
