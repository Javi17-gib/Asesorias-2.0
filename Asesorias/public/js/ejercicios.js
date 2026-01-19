document.addEventListener("DOMContentLoaded", () => {
    const modalEjeUnidad = new bootstrap.Modal(document.getElementById("modalEjeUnidad"));
    const modalEjercicio = new bootstrap.Modal(document.getElementById("modalEjercicio"));
    const usuarioNivel = document.querySelector('meta[name="usuario-nivel"]')?.content || 'estudiante';
    const materiaId = document.getElementById("ejerciciosApp")?.dataset.materiaId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const unidadesContainer = document.getElementById("unidadesContainerEjercicios");

    // ---------------------- UNIDAD ----------------------
    window.abrirModalEjeUnidad = () => {
        document.getElementById("formNuevaEjeUnidad").reset();
        document.getElementById("ejeUnidadId").value = "";
        modalEjeUnidad.show();
    };

    window.abrirModalEditarEjeUnidad = (id, nombre, titulo, numero) => {
        document.getElementById("ejeUnidadId").value = id;
        document.getElementById("nombreEjeUnidad").value = nombre;
        document.getElementById("tituloEjeUnidad").value = titulo;
        document.getElementById("numeroEjeUnidad").value = numero;
        modalEjeUnidad.show();
    };

    document.getElementById("formNuevaEjeUnidad").addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('nombre', document.getElementById("nombreEjeUnidad").value);
        formData.append('titulo', document.getElementById("tituloEjeUnidad").value);
        formData.append('numero_unidad', document.getElementById("numeroEjeUnidad").value);

        const unidadId = document.getElementById("ejeUnidadId").value;
        let url = `/materia/${materiaId}/ejeunidad`;
        let method = 'POST';
        if (unidadId) {
            url = `/ejeunidad/${unidadId}`;
            formData.append('_method', 'PUT');
        }

        try {
            const res = await fetch(url, { method: 'POST', body: formData });
            const data = await res.json();

            if (data.success) {
                location.reload(); // o actualizar DOM como en temario
            } else {
                alert(data.mensaje || 'Error al guardar unidad');
            }
        } catch (err) {
            console.error(err);
            alert('Error al guardar unidad. Revisa la consola.');
        }
    });

    window.eliminarEjeUnidad = async (id) => {
        if (!confirm("¿Eliminar esta unidad?")) return;

        try {
            const res = await fetch(`/ejeunidad/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.mensaje || 'Error al eliminar');
        } catch (err) {
            console.error(err);
            alert('Error al eliminar unidad.');
        }
    };

    // ---------------------- EJERCICIO ----------------------
    window.abrirModalEjercicioNueva = (unidadId) => {
        document.getElementById("ejercicioId").value = '';
        document.getElementById("ejercicioUnidadId").value = unidadId;
        document.getElementById("nombreEjercicio").value = '';
        document.getElementById("contenidoEjercicio").value = '';
        modalEjercicio.show();
    };

    window.abrirModalEjercicio = (id, nombre, contenido, unidadId) => {
        document.getElementById("ejercicioId").value = id;
        document.getElementById("ejercicioUnidadId").value = unidadId;
        document.getElementById("nombreEjercicio").value = nombre;
        document.getElementById("contenidoEjercicio").value = contenido;
        modalEjercicio.show();
    };

    document.getElementById("formNuevoEjercicio").addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('nombre', document.getElementById("nombreEjercicio").value);
        formData.append('contenido', document.getElementById("contenidoEjercicio").value);
        formData.append('id_eje_unidad', document.getElementById("ejercicioUnidadId").value);

        const ejercicioId = document.getElementById("ejercicioId").value;
        let url = '/ejercicios';
        if (ejercicioId) {
            url = `/ejercicios/${ejercicioId}`;
            formData.append('_method', 'PUT');
        }

        try {
            const res = await fetch(url, { method: 'POST', body: formData });
            const data = await res.json();

            if (data.success) location.reload();
            else alert(data.mensaje || 'Error al guardar ejercicio');
        } catch (err) {
            console.error(err);
            alert('Error al guardar ejercicio. Revisa la consola.');
        }
    });

    window.eliminarEjercicio = async (id) => {
        if (!confirm("¿Eliminar este ejercicio?")) return;
        try {
            const res = await fetch(`/ejercicios/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.mensaje || 'Error al eliminar ejercicio');
        } catch (err) {
            console.error(err);
            alert('Error al eliminar ejercicio.');
        }
    };
});
