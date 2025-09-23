{{-- resources/views/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $materia->nombre ?? 'Materia' }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>

@php
    $usuario_nombre = session('usuario', 'Invitado');
    $usuario_id = session('id_usuario');

    // Foto de usuario por defecto
    $foto_usuario = 'https://itsncg.edu.mx/wp-content/uploads/2021/03/default-user.png';
@endphp

{{-- Header --}}
<header class="position-relative bg-purple-700 p-2" style="background-color:#541469;">
  <h1 style="font-family: 'Times New Roman', serif; font-size:55px; color:white;" 
      class="position-absolute top-50 start-50 translate-middle mb-0">
      {{ $materia->nombre ?? 'Materia' }}
  </h1>

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

  <nav class="mt-5">
    <ul class="nav justify-content-center">
      <li class="nav-item mx-5"><a class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Inicio</a></li>
      <li class="nav-item mx-5"><a class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Fórmulas</a></li>
      <li class="nav-item dropdown mx-5">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
           style="font-family: 'Times New Roman', serif; font-size:22px; font-weight:bold; color:white;">
          Acerca de
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Contenido</a></li>
          <li><a class="dropdown-item" href="#">Desarrollo de plataforma</a></li>
        </ul>
      </li>
      <li class="nav-item mx-5"><a class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Preguntas</a></li>
    </ul>
  </nav>
</header>

<div class="container-fluid">
  <div class="row">
    {{-- Aside Temario --}}
    <aside class="col-md-3 col-lg-2 mt-2">
      <div class="card shadow-sm mt-4 rounded-lg" style="background-color:#711092; color:white;">
        <div class="card-body">
          <h5 class="card-title text-center">Temario</h5>

          @foreach($materia->unidades as $unidad)
          <div class="btn-group dropend mt-3 w-100">
            <button type="button" class="btn btn-light w-100 text-start dropdown-toggle rounded" data-bs-toggle="dropdown">
              {{ $unidad->nombre }}
            </button>
            <ul class="dropdown-menu dropdown-menu-dark w-100%">
              <li><h6 class="dropdown-header">{{ $unidad->nombre }}</h6></li>
              @foreach($unidad->subtemas as $subtema)
              <li>
                <a class="dropdown-item" href="#">{{ $subtema->nombre }}</a>
              </li>
              @endforeach
            </ul>
          </div>
          @endforeach

        </div>
      </div>
    </aside>

    {{-- Contenido --}}
    <main class="col-md-9 col-lg-10 mt-2">
      <h1 class="fw-bold">{{ $materia->nombre ?? '' }}</h1>
      <h5>Introducción a la materia</h5>
      <p>
        Aquí puedes poner la descripción de la materia, contenido introductorio, etc.
      </p>

      <div class="row mt-5">
        <div class="col-md-6 text-center">
          <img src="{{ asset('img/logo.webp') }}" class="img-fluid rounded shadow" alt="Imagen 1">
        </div>
        <div class="col-md-6 text-center">
          <img src="{{ asset('img/logo.webp') }}" class="img-fluid rounded shadow" alt="Imagen 2">
        </div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
