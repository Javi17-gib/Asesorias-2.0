<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Asesorías</title>

<!-- Bootstrap y estilos -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<header class="position-relative">
    <div id="logo">
        <img src="{{ asset('img/tec.jpg') }}" alt="Logo">
    </div>

    <div class="bg-purple text-white py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="m-0 fs-4">Asesorías Académicas</h1>

            <nav>
                <ul class="nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">Materias</a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item" onclick="abrirModal()">➕ Nueva Materia</a></li>
                            @foreach($materias as $materia)
                                <li>
                                    <a class="dropdown-item" href="{{ url('login.php?materia_id=' . $materia->id) }}">
                                        {{ $materia->nombre }} ({{ $materia->codigo_materia }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<main>
    <video muted autoplay loop src="{{ asset('img/tec.mp4') }}" class="w-100 vh-100 object-fit-cover"></video>
</main>

<!-- Modal Nueva Materia -->
<div class="modal fade" id="modalMateria" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Materia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formNuevaMateria">
          @csrf
          <input type="text" name="nombre" placeholder="Nombre de la materia" class="form-control mb-2" required>
          <button type="submit" class="btn btn-primary w-100">Guardar</button>
        </form>
        <div id="mensaje" class="mt-2 text-success"></div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const urlMateriasStore = "{{ route('materias.store') }}";
</script>
<script src="{{ asset('js/nuevaMateria.js') }}"></script>
</body>
</html>
