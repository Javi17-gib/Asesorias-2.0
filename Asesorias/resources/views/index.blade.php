<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $materia->nombre ?? 'Materia' }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="usuario-nivel" content="{{ $usuario_nivel ?? 'estudiante' }}">
<meta name="chatbot-url" content="{{ url('/chatbot/message') }}">

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
</head>

<body>

@include('layouts.header')

<div class="container-fluid">
  <div class="row">

    <!-- ASIDE -->
    <aside class="col-md-3 col-lg-2 mt-2 sidebar">
      @include('layouts.temas', ['usuario_nivel' => $usuario_nivel, 'materia' => $materia])
    </aside>

    <!-- MAIN -->
    <main class="col-md-9 col-lg-10 mt-2">

      <div class="glass">

        <h1 class="fw-bold titulo-principal">{{ $materia->nombre ?? '' }}</h1>
        <h5 class="subtitulo">Introducción a la materia</h5>

        {{-- DESCRIPCIÓN --}}
        @if($usuario_nivel === 'docente')
          <textarea id="descripcionMateria" name="descripcion">
            {!! $materia->descripcion->descripcion ?? 'Aquí puedes poner la descripción de la materia...' !!}
          </textarea>

          <button id="guardarDescripcionMateria" class="btn btn-primary mt-2">
            Guardar descripción
          </button>

          <div id="mensajeDescripcion" class="mt-2 text-success"></div>

        @else
          <div class="glass mt-3">
            {!! $materia->descripcion->descripcion ?? 'Aquí puedes poner la descripción de la materia...' !!}
          </div>
        @endif

      </div>

      {{-- IMÁGENES --}}
      <div class="row mt-5">
        @php
          $imagenes = $materia->imagenes ?? collect();
          for ($i = $imagenes->count(); $i < 2; $i++) {
              $imagenes->push(null);
          }
        @endphp

        @for($i = 0; $i < 2; $i++)
          <div class="col-md-6 text-center mb-3">
            <img src="{{ $imagenes[$i]?->ruta ? asset($imagenes[$i]->ruta) : asset('img/logo.webp') }}"
                 class="img-fluid rounded shadow imagen-pro"
                 alt="Imagen {{ $i + 1 }}">

            @if($usuario_nivel === 'docente')
              <form class="mt-2 imagen-form" enctype="multipart/form-data" data-index="{{ $i }}">
                <input type="file" name="imagen" class="form-control">
                <button type="submit" class="btn btn-primary btn-sm mt-2">Subir</button>
              </form>
              <div class="text-success mt-1 mensaje-imagen"></div>
            @endif
          </div>
        @endfor
      </div>

    </main>
  </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<script>
const urlDescripcionStore = "{{ route('descripcion.store') }}";

@if($usuario_nivel === 'docente')
$(document).ready(function() {

    $('#descripcionMateria').summernote({
        height: 250
    });

    $('#guardarDescripcionMateria').click(async function() {

        const contenido = $('#descripcionMateria').summernote('code');
        const materiaId = "{{ $materia->id }}";
        const token = $('meta[name="csrf-token"]').attr('content');

        try {
            const res = await fetch(urlDescripcionStore, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    id_materia: materiaId,
                    descripcion: contenido
                })
            });

            const data = await res.json();

            $('#mensajeDescripcion').text(
                data.success ? 'Descripción guardada correctamente' : 'Error'
            );

        } catch(e){
            console.error(e);
            $('#mensajeDescripcion').text('Error en la petición');
        }

    });

});
@endif
</script>

<script src="{{ asset('js/temario.js') }}"></script>

</body>
</html>