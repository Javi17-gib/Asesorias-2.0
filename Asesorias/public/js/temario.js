document.addEventListener("DOMContentLoaded", () => {
    const modalUnidad = new bootstrap.Modal(document.getElementById("modalUnidad"));
    const modalSubtema = new bootstrap.Modal(document.getElementById("modalSubtema"));
    const unidadesContainer = document.getElementById("unidadesContainer");
    const usuarioNivel = document.querySelector('meta[name="usuario-nivel"]')?.content || 'estudiante';
    const temarioApp = document.getElementById("temarioApp");
    const materiaId = temarioApp.dataset.materiaId;

    // Mostrar modal unidad
    window.abrirModalUnidad = () => modalUnidad.show();

    // Mostrar modal subtema con unidadId
    window.abrirModalSubtema = (unidadId) => {
        document.getElementById("subtemaUnidadId").value = unidadId;
        modalSubtema.show();
    };

    // Agregar nueva unidad
    document.getElementById("formNuevaUnidad").addEventListener("submit", async function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch(`/materia/${materiaId}/unidad`, {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.reset();
                modalUnidad.hide();

                const unidad = data.unidad;

                const unidadHTML = `
                    <div class="btn-group dropend mt-3 w-100" data-unidad-id="${unidad.id}">
                        <button type="button" class="btn btn-light w-100 text-start dropdown-toggle rounded" data-bs-toggle="dropdown">
                            ${unidad.nombre}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark w-100%">
                            <li><h6 class="dropdown-header">${unidad.titulo || ''}</h6></li>
                            <li><span class="dropdown-item text-muted">No hay subtemas aún</span></li>
                            ${usuarioNivel === 'docente' ? `
                                <li>
                                    <button class="btn btn-sm btn-success w-100 mt-2" onclick="abrirModalSubtema(${unidad.id})">+ Nuevo Subtema</button>
                                </li>` : ''}
                        </ul>
                    </div>
                `;
                unidadesContainer.insertAdjacentHTML("beforeend", unidadHTML);
            } else {
                document.getElementById("mensajeUnidad").innerText = data.mensaje || 'Error al guardar unidad.';
            }
        } catch (error) {
            console.error(error);
            document.getElementById("mensajeUnidad").innerText = 'Error al guardar unidad.';
        }
    });

    document.getElementById("formNuevoSubtema").addEventListener("submit", async function(e){
    e.preventDefault();
    const formData = new FormData(this);

    try {
        const response = await fetch("/subtemas", {
            method: "POST",
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: formData
        });

        // Antes de hacer json(), verifica si la respuesta es OK (200-299)
        if (!response.ok) {
            // Lee el texto (HTML del error) y lo muestra en consola
            const text = await response.text();
            console.error("Respuesta no OK:", text);
            throw new Error("Error en la respuesta del servidor");
        }

        const data = await response.json();

        if(data.success){
            this.reset();
            modalSubtema.hide();

            const subtema = data.subtema;
            const dropdownMenu = document.querySelector(`.btn-group[data-unidad-id="${subtema.id_unidad}"] .dropdown-menu`);
            if(dropdownMenu){
                dropdownMenu.insertAdjacentHTML("beforeend", `<li><a class="dropdown-item" href="#">${subtema.nombre}</a></li>`);
            }

        } else {
            document.getElementById("mensajeSubtema").innerText = data.mensaje || 'Error';
        }

    } catch(err){
        console.error(err);
        document.getElementById("mensajeSubtema").innerText = 'Error al guardar subtema';
    }
});

});

document.addEventListener('DOMContentLoaded', () => {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#descripcionMateria',
            height: 300,
            menubar: false,
            plugins: 'lists link image paste help wordcount',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link image | removeformat | help'
        });
    }

    const btnGuardar = document.getElementById('guardarDescripcion');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', async () => {
            const descripcion = tinymce.get('descripcionMateria').getContent();
            const idMateria = "{{ $materia->id }}";

            try {
                const response = await fetch("{{ route('descripcion.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id_materia: idMateria, descripcion })
                });

                const data = await response.json();
                if (data.success) alert(data.mensaje);
            } catch (err) {
                console.error(err);
                alert('Error al guardar la descripción');
            }
        });
    }
});

