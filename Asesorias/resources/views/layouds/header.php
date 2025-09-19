@php
use Illuminate\Support\Facades\DB;

// Obtener usuario desde sesión de Laravel
$usuario_nombre = session('usuario', 'Invitado'); 
$usuario_id = session('id_usuario');

// Foto por defecto
$foto_usuario = asset('img/logo.webp');

// Solo intentamos buscar foto si hay usuario_id
if ($usuario_id) {
    $foto = DB::table('fotos_usuarios')
        ->where('usuario_id', $usuario_id)
        ->orderBy('fecha_subida', 'desc')
        ->first();

    if ($foto) {
        $foto_usuario = asset($foto->ruta);
    }
}
@endphp

<header class="position-relative p-2" style="background-color:#541469;">
  <!-- Título centrado absoluto -->
  <h1 style="font-family: 'Times New Roman', serif; font-size:55px; color:white;" 
      class="position-absolute top-50 start-50 translate-middle mb-0">Matemáticas Discretas</h1>

  <!-- Perfil de usuario alineado a la derecha -->
  <div class="d-flex align-items-center position-relative" style="justify-content:flex-end; padding-right:20px;">
    <img src="{{ $foto_usuario }}" alt="Usuario" class="rounded-circle me-2" style="width:40px; height:40px; object-fit:cover;">
    <div class="dropdown">
      <a class="btn btn-sm btn-outline-light dropdown-toggle" href="#" role="button" id="userDropdown"
         data-bs-toggle="dropdown" aria-expanded="false">
        {{ $usuario_nombre }}
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li><a href="{{ url('/perfil') }}" class="dropdown-item"><i class="bi bi-person-fill"></i> Perfil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a href="{{ url('/Login') }}" class="dropdown-item"><i class="bi bi-box-arrow-in-left"></i> Cerrar Sesión</a></li>
      </ul>
    </div>
  </div>

  <!-- Menú principal debajo del título -->
  <nav class="mt-5">
    <ul class="nav justify-content-center">
      <li class="nav-item mx-5">
        <a class="nav-link" href="{{ url('/inicio') }}" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Inicio</a>
      </li>
      <li class="nav-item mx-5">
        <a class="nav-link" href="{{ url('/formulas') }}" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Fórmulas</a>
      </li>
      <li class="nav-item dropdown mx-5">
        <a class="nav-link dropdown-toggle" 
           href="#" role="button" 
           data-bs-toggle="dropdown" 
           aria-expanded="false"
           style="font-family: 'Times New Roman', serif; font-size:22px; font-weight:bold; color:white;">
          Acerca de
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ url('/smayra') }}">Contenido</a></li>
          <li><a class="dropdown-item" href="{{ url('/desarrolladores') }}">Desarrollo de plataforma</a></li>
        </ul>
      </li>
      <li class="nav-item mx-5">
        <a class="nav-link" href="{{ url('/preguntas') }}" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Preguntas</a>
      </li>
    </ul>
  </nav>
</header>
