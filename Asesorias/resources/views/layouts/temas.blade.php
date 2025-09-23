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
              <a class="dropdown-item" href="#">
                {{ $subtema->nombre }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
</div>
