<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/gym-logo.png') }}" alt="Gym Logo" width="40" height="40" class="mr-2">
            Body Iron Fitness
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @auth
                    <!-- Links dinámicos según el rol -->
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Panel de Admin</a>
                        </li>
                    @elseif(auth()->user()->role === 'recepcionista')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('recepcion.clientes.index') }}">Gestionar Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('recepcion.membresias.index') }}">Membresías</a>
                        </li>
                    @elseif(auth()->user()->role === 'entrenador')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('entrenador.clases.index') }}">Horario de Clases</a>
                        </li>
                    @endif
                    <!-- Menú del usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->nombre }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
