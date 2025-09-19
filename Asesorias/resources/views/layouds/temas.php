@php
// Ejemplo de unidad activa (puedes pasar $n_tema desde el controlador o sesión)
$n_tema = session('n_tema', 0); // valor por defecto 0 si no hay sesión
@endphp

<div class="card shadow-sm mt-4 rounded-lg" style="background-color:#711092; color:white;">
  <div class="card-body">
    <h5 class="card-title text-center">Temario</h5>

    <!-- Unidad 1 -->
    <div class="btn-group dropend mt-3 w-100">
      <button type="button" class="btn btn-light w-100$ text-start dropdown-toggle rounded" data-bs-toggle="dropdown">
        Unidad 1
      </button>
      <ul class="dropdown-menu dropdown-menu-dark w-100%">
        <li><h6 class="dropdown-header">Unidad 1 Sistemas numéricos</h6></li>
        <li>
          <a class="dropdown-item @if($n_tema == 1) disabled @endif" href="{{ url('/unidad1/tema1') }}">
            1.1 Sistemas numéricos
          </a>
        </li>
        <li>
          <a class="dropdown-item @if($n_tema == 2) disabled @endif" href="{{ url('/unidad1/tema2') }}">
            1.2 Conversiones
          </a>
        </li>
      </ul>
    </div>

    <!-- Unidad 2 (ejemplo) -->
    <div class="btn-group dropend mt-3 w-100">
      <button type="button" class="btn btn-light w-100% text-start dropdown-toggle rounded" data-bs-toggle="dropdown">
        Unidad 2
      </button>
      <ul class="dropdown-menu dropdown-menu-dark w-100%">
        <li><h6 class="dropdown-header">Unidad 2 Álgebra y lógica</h6></li>
        <li>
          <a class="dropdown-item @if($n_tema == 3) disabled @endif" href="{{ url('/unidad2/tema1') }}">
            2.1 Operaciones algebraicas
          </a>
        </li>
        <li>
          <a class="dropdown-item @if($n_tema == 4) disabled @endif" href="{{ url('/unidad2/tema2') }}">
            2.2 Lógica proposicional
          </a>
        </li>
      </ul>
    </div>

    <!-- Puedes agregar más unidades de la misma forma -->

  </div>
</div>
