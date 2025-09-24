<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $materia->nombre ?? 'Materia' }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
<meta name="subtemas-store" content="{{ route('subtemas.store') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="usuario-nivel" content="{{ $usuario_nivel ?? 'estudiante' }}">

</head>
<body>

@include('layouts.header')

<div class="container-fluid">
  <div class="row">
    {{-- Aside --}}
    <aside class="col-md-3 col-lg-2 mt-2">
      @include('layouts.temas', ['usuario_nivel' => session('usuario_nivel'), 'materia' => $materia])
    </aside>

    {{-- Contenido principal --}}
    <main class="col-md-9 col-lg-10 mt-2">
      <h1 class="fw-bold">{{ $materia->nombre ?? '' }}</h1>
      <h5>Introducción a la materia</h5>
      <p>Aquí puedes poner la descripción de la materia, contenido introductorio, etc.</p>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const urlUnidadesStore = "{{ route('unidad.store', $materia->id ?? 0) }}";
    const urlSubtemasStore = "{{ route('subtemas.store') }}";
    const usuarioNivel = "{{ $usuario_nivel ?? '' }}";
</script>
<script src="{{ asset('js/temario.js') }}"></script>

</body>
</html>
