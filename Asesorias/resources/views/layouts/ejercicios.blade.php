<div id="ejerciciosApp" data-materia-id="{{ $materia?->id ?? 0 }}" class="card shadow-sm mt-4 rounded-lg"
    style="background-color:#711092; color:white;">
    <div class="card-body">
        <h5 class="card-title text-center">Ejercicios</h5>

        @if($usuario_nivel === 'docente')
        <button class="btn btn-primary w-100 mb-3" onclick="abrirModalEjeUnidad()">+ Nueva Unidad de Ejercicios</button>
        @endif

        <div id="unidadesContainerEjercicios">
            @foreach($materia->ejeunidades ?? [] as $unidad)
            <div class="btn-group dropend mt-3 w-100" data-unidad-id="{{ $unidad?->id ?? 0 }}">
                <button type="button" class="btn btn-light w-100 text-start dropdown-toggle rounded"
                    data-bs-toggle="dropdown">
                    {{ $unidad?->nombre ?? 'Unidad sin nombre' }}
                </button>

                @if($usuario_nivel === 'docente')
                <button class="btn btn-outline-warning btn-sm ms-2"
                        style="width:45px; height:36px; padding:0; display:flex; align-items:center; justify-content:center; border-radius: 10px;"
                        onclick="abrirModalEditarEjeUnidad({{ $unidad->id }}, '{{ $unidad->nombre }}', '{{ $unidad->titulo }}', {{ $unidad->numero_unidad }})">
                    ✏️
                </button>
                <button class="btn btn-outline-danger btn-sm ms-2"
                        style="width:45px; height:36px; padding:0; display:flex; align-items:center; justify-content:center; border-radius: 10px;"
                        onclick="eliminarEjeUnidad({{ $unidad->id }})">
                    🗑️
                </button>
                @endif

                <ul class="dropdown-menu dropdown-menu-dark" style="min-width: 250px;">
                    <li>
                        <h6 class="dropdown-header">{{ $unidad?->titulo ?? '' }}</h6>
                    </li>

                    {{-- Subtemas --}}
                    @forelse($unidad->subtemas ?? [] as $subtema)
                    <li class="px-2 d-flex justify-content-between align-items-center">
                        <a class="dropdown-item p-0" href="#"
                           onclick="abrirModalSubtema({{ $subtema->id }}, '{{ addslashes($subtema->nombre) }}', {{ $unidad->id }})">
                            {{ $subtema->nombre }}
                        </a>
                        @if($usuario_nivel === 'docente')
                        <div class="btn-group btn-sm ms-2">
                            <button class="btn btn-outline-warning btn-sm"
                                    style="width:30px; height:30px; padding:0; display:flex; align-items:center; justify-content:center; border-radius: 10px;"
                                    onclick="abrirModalEditarSubtema({{ $subtema->id }}, '{{ addslashes($subtema->nombre) }}', {{ $unidad->id }})">
                                ✏️
                            </button>
                            <button class="btn btn-outline-danger btn-sm ms-2"
                                    style="width:30px; height:30px; padding:0; display:flex; align-items:center; justify-content:center; border-radius: 10px;"
                                    onclick="eliminarSubtema({{ $subtema->id }})">
                                🗑️
                            </button>
                        </div>
                        @endif
                    </li>
                    @empty
                    <li><span class="dropdown-item text-muted">No hay subtemas aún</span></li>
                    @endforelse

                    @if($usuario_nivel === 'docente')
                    <li>
                        <button class="btn btn-success btn-sm w-100 mt-2"
                                onclick="abrirModalSubtemaNueva({{ $unidad->id }})">
                            + Nuevo Subtema
                        </button>
                    </li>
                    @endif

                    {{-- Ejercicios --}}
                    @forelse($unidad->ejercicios ?? [] as $ejercicio)
                    <li class="px-2 d-flex justify-content-between align-items-center mt-2">
                        <a class="dropdown-item p-0" href="#"
                           onclick="abrirModalEjercicio({{ $ejercicio->id }}, '{{ addslashes($ejercicio->nombre) }}', '{{ addslashes($ejercicio->contenido ?? '') }}', {{ $unidad->id }})">
                            {{ $ejercicio->nombre }}
                        </a>
                        @if($usuario_nivel === 'docente')
                        <button class="btn btn-outline-danger btn-sm"
                                onclick="eliminarEjercicio({{ $ejercicio->id }})">🗑️</button>
                        @endif
                    </li>
                    @empty
                    <li><span class="dropdown-item text-muted">No hay ejercicios aún</span></li>
                    @endforelse

                    @if($usuario_nivel === 'docente')
                    <li>
                        <button class="btn btn-success btn-sm w-100 mt-2"
                                onclick="abrirModalEjercicioNueva({{ $unidad->id }})">
                            + Nuevo Ejercicio
                        </button>
                    </li>
                    @endif

                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Modal Unidad Ejercicios --}}
<div class="modal fade" id="modalEjeUnidad" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Unidad de Ejercicios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevaEjeUnidad">
                    @csrf
                    <input type="hidden" id="ejeUnidadId" name="ejeUnidadId" />
                    <input type="text" name="nombre" id="nombreEjeUnidad" placeholder="Unidad (1,2,3...)" class="form-control mb-2" required />
                    <input type="text" name="titulo" id="tituloEjeUnidad" placeholder="Título" class="form-control mb-2" />
                    <input type="number" name="numero_unidad" id="numeroEjeUnidad" placeholder="Número de unidad" class="form-control mb-2" min="1" value="1" required />
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </form>
                <div id="mensajeEjeUnidad" class="mt-2 text-success"></div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Subtema --}}
<div class="modal fade" id="modalSubtema" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Subtema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoSubtema">
                    @csrf
                    <input type="hidden" name="subtemaId" id="subtemaId" />
                    <input type="hidden" name="unidadId" id="subtemaUnidadId" />
                    <input type="text" name="nombre" id="nombreSubtema" class="form-control mb-2" placeholder="Nombre del subtema" required />
                    <button type="submit" class="btn btn-success w-100">Guardar</button>
                </form>
                <div id="mensajeSubtema" class="mt-2 text-success"></div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ejercicio --}}
<div class="modal fade" id="modalEjercicio" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Ejercicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoEjercicio">
                    @csrf
                    <input type="hidden" name="ejercicioId" id="ejercicioId" />
                    <input type="hidden" name="unidadId" id="ejercicioUnidadId" />
                    <input type="text" name="nombre" id="nombreEjercicio" class="form-control mb-2" placeholder="Nombre del ejercicio" required />
                    <textarea name="contenido" id="contenidoEjercicio" class="form-control mb-2" placeholder="Contenido / descripción del ejercicio"></textarea>
                    <button type="submit" class="btn btn-success w-100">Guardar</button>
                </form>
                <div id="mensajeEjercicio" class="mt-2 text-success"></div>
            </div>
        </div>
    </div>
</div>
