@php
$usuario_nombre = session('usuario_nombre', 'Invitado');
$foto_usuario = asset('img/default.jpeg');
@endphp

<header class="position-relative bg-purple-700 p-2" style="background-color:#541469;">
    <!-- Título centrado -->
    <h1 style="font-family: 'Times New Roman', serif; font-size:60px; color:white;" 
        class="position-absolute top-50 start-50 translate-middle mb-0">
        {{ $materia->nombre ?? 'Materia' }}
    </h1>

    <!-- Perfil de usuario a la derecha -->
    <div class="d-flex align-items-center position-relative" style="justify-content:flex-end; padding-right:20px;">
        <img src="{{ $foto_usuario }}" alt="Usuario" class="rounded-circle me-2" style="width:40px; height:40px; object-fit:cover;">
        <div class="dropdown">
            <a class="btn btn-sm btn-outline-light dropdown-toggle" href="#" role="button" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ $usuario_nombre }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a href="#" class="dropdown-item"><i class="bi bi-person-fill"></i> Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a href="{{ route('logout') }}" class="dropdown-item"><i class="bi bi-box-arrow-in-left"></i> Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
    <!-- Menú principal debajo del título -->
    <nav class="mt-5">
        <ul class="nav justify-content-center">
            <li class="nav-item mx-5">
                <a class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Inicio</a>
            </li>
            <li class="nav-item mx-5">
                <a class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Preguntas</a>
            </li>
            <li class="nav-item mx-5">
                <a class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">ChatBot</a>
            </li>
        </ul>
    </nav>
</header>
