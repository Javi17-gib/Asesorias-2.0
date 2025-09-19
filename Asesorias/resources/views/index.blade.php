@php
use Illuminate\Support\Facades\DB;

// Obtener usuario desde sesión de Laravel
$usuario = session('usuario', 'Invitado'); // valor por defecto si no hay sesión
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matemáticas Discretas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- CSS adicional -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>

    <!-- Header -->
    @include('layouds.header', ['foto_usuario' => $foto_usuario, 'usuario' => $usuario])

    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <aside class="col-md-3 col-lg-2 mt-2">
                @include('layouds.temas')
            </aside>

            <!-- Contenido principal -->
            <main class="col-md-9 col-lg-10 mt-2">
                <h1 class="fw-bold">Matemáticas Discretas</h1>
                <h5>¿Qué son las Matemáticas Discretas?</h5>
                <p>
                    Esta asignatura aporta al perfil del egresado los conocimientos lógico-matemáticos
                    para entender, inferir, aplicar y desarrollar soluciones en problemas discretos.
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
