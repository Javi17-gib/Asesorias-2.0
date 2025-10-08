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





<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.header')

<div class="container-fluid">
  <div class="row">
    {{-- Aside fijo --}}
    <aside class="col-md-3 col-lg-2 mt-2">
      @include('layouts.temas', ['usuario_nivel' => $usuario_nivel, 'materia' => $materia])
    </aside>

    {{-- Contenido principal desplazable --}}
    <main class="col-md-9 col-lg-10 mt-2">
      <h1 class="fw-bold">{{ $materia->nombre ?? '' }}</h1>
      <h5>Introducción a la materia</h5>

      {{-- Descripción --}}
      @if($usuario_nivel === 'docente')
        <textarea id="descripcionMateria" name="descripcion">
            {!! $materia->descripcion->descripcion ?? 'Aquí puedes poner la descripción de la materia, contenido introductorio, etc.' !!}
        </textarea>
        <button id="guardarDescripcion" class="btn btn-primary mt-2">Guardar descripción</button>
        <div id="mensajeDescripcion" class="mt-2 text-success"></div>
      @else
        <div class="border p-3 rounded">
          {!! $materia->descripcion->descripcion ?? 'Aquí puedes poner la descripción de la materia, contenido introductorio, etc.' !!}
        </div>
      @endif

      {{-- Solo 2 imágenes --}}
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
                 class="img-fluid rounded shadow" 
                 style="width: 400px; height: 250px; object-fit: cover;" 
                 alt="Imagen {{ $i + 1 }}">

            @if($usuario_nivel === 'docente')
              <form class="mt-2 imagen-form" enctype="multipart/form-data" data-index="{{ $i }}">
                <input type="file" name="imagen" accept="image/*" required>
                <button type="submit" class="btn btn-sm btn-primary mt-1">Subir / Cambiar</button>
              </form>
              <div class="text-success mt-1 mensaje-imagen"></div>
            @endif
          </div>
        @endfor
      </div>
    </main>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<script>
const urlDescripcionStore = "{{ route('descripcion.store') }}";
const urlImagenStore = "{{ route('imagen.store') }}";
const usuarioNivel = "{{ $usuario_nivel ?? '' }}";

@if($usuario_nivel === 'docente')
$(document).ready(function() {
    // Summernote
    $('#descripcionMateria').summernote({
        height: 250,
        placeholder: 'Escribe la descripción de la materia aquí...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Guardar descripción
    $('#guardarDescripcion').click(async function() {
        const contenido = $('#descripcionMateria').summernote('code');
        const materiaId = "{{ $materia->id }}";
        const token = $('meta[name="csrf-token"]').attr('content');

        try {
            const res = await fetch(urlDescripcionStore, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ id_materia: materiaId, descripcion: contenido })
            });
            const data = await res.json();
            $('#mensajeDescripcion').text(data.success ? 'Descripción guardada correctamente' : data.mensaje || 'Error al guardar');
        } catch(e) {
            console.error(e);
            $('#mensajeDescripcion').text('Error en la petición');
        }
    });

    // Subir o reemplazar imágenes
    $('.imagen-form').submit(function(e){
        e.preventDefault();
        const form = $(this);
        const index = form.data('index');
        const archivo = form.find('input[name="imagen"]')[0].files[0];
        if(!archivo) return;

        const formData = new FormData();
        formData.append('imagen', archivo);
        formData.append('id_materia', "{{ $materia->id }}");
        formData.append('index', index);

        const mensajeDiv = form.siblings('.mensaje-imagen');

        fetch(urlImagenStore, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                mensajeDiv.text('Imagen guardada correctamente');
                form.prev('img').attr('src', "{{ url('/') }}/" + data.imagen.ruta + '?' + new Date().getTime());
            } else {
                mensajeDiv.text(data.mensaje || 'Error al guardar imagen');
            }
        })
        .catch(err => {
            console.error(err);
            mensajeDiv.text('Error en la petición');
        });
    });
});
@endif
</script>

<script src="{{ asset('js/temario.js') }}"></script>
</body>
</html>
