document.addEventListener("DOMContentLoaded", () => {

    const modalEjeUnidad = new bootstrap.Modal(document.getElementById("modalEjeUnidad"));
    const modalSubtema = new bootstrap.Modal(document.getElementById("modalSubtema"));
    const modalEjercicio = new bootstrap.Modal(document.getElementById("modalEjercicio"));

    const app = document.getElementById("ejerciciosApp");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const materiaId = app?.dataset.materiaId;

    /* ================== UNIDAD ================== */
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
        const form = e.target;
        const formData = new FormData(form);
        const unidadId = document.getElementById("ejeUnidadId").value;

        let url = `/materia/${materiaId}/unidad`;
        if (unidadId) {
            url = `/unidad/${unidadId}`;
            formData.append('_method', 'PUT');
        }

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.mensaje || 'Error al guardar unidad');
        } catch (err) {
            console.error(err);
            alert('Error al guardar unidad');
        }
    });

    window.eliminarEjeUnidad = async (id) => {
        if (!confirm("¿Eliminar esta unidad?")) return;
        try {
            const res = await fetch(`/unidad/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.mensaje || 'Error al eliminar unidad');
        } catch (err) {
            console.error(err);
            alert('Error al eliminar unidad');
        }
    };

    /* ================== SUBTEMA ================== */
    window.abrirModalSubtemaNueva = (unidadId) => {
        const form = document.getElementById("formNuevoSubtema");
        form.reset();
        document.getElementById("subtemaId").value = "";
        document.getElementById("subtemaUnidadId").value = unidadId;
        modalSubtema.show();
    };

    window.abrirModalSubtema = (id, nombre, unidadId) => {
        document.getElementById("subtemaId").value = id;
        document.getElementById("nombreSubtema").value = nombre;
        document.getElementById("subtemaUnidadId").value = unidadId;
        modalSubtema.show();
    };

    window.abrirModalEditarSubtema = (id, nombre, unidadId) => {
        document.getElementById("subtemaId").value = id;
        document.getElementById("nombreSubtema").value = nombre;
        document.getElementById("subtemaUnidadId").value = unidadId;
        modalSubtema.show();
    };

    document.getElementById("formNuevoSubtema").addEventListener("submit", async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const subtemaId = document.getElementById("subtemaId").value;

        let url = '/subtemas';
        if (subtemaId) {
            url = `/subtemas/${subtemaId}`;
            formData.append('_method', 'PUT');
        }

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.mensaje || 'Error al guardar subtema');
        } catch (err) {
            console.error(err);
            alert('Error al guardar subtema');
        }
    });

    window.eliminarSubtema = async (id) => {
        if (!confirm("¿Eliminar este subtema?")) return;
        try {
            const res = await fetch(`/subtemas/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.mensaje || 'Error al eliminar subtema');
        } catch (err) {
            console.error(err);
            alert('Error al eliminar subtema');
        }
    };

    /* ================== EJERCICIO ================== */
    window.abrirModalEjercicioNueva = (unidadId) => {
        const form = document.getElementById("formNuevoEjercicio");
        form.reset();
        document.getElementById("ejercicioId").value = "";
        document.getElementById("ejercicioUnidadId").value = unidadId;
        modalEjercicio.show();
    };

    window.abrirModalEjercicio = (id, nombre, contenido, unidadId) => {
        document.getElementById("ejercicioId").value = id;
        document.getElementById("nombreEjercicio").value = nombre;
        document.getElementById("contenidoEjercicio").value = contenido;
        document.getElementById("ejercicioUnidadId").value = unidadId;
        modalEjercicio.show();
    };

    document.getElementById("formNuevoEjercicio").addEventListener("submit", async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const ejercicioId = document.getElementById("ejercicioId").value;

        let url = '/ejercicios';
        if (ejercicioId) {
            url = `/ejercicios/${ejercicioId}`;
            formData.append('_method', 'PUT');
        }

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.mensaje || 'Error al guardar ejercicio');
        } catch (err) {
            console.error(err);
            alert('Error al guardar ejercicio');
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
            alert('Error al eliminar ejercicio');
        }
    };

});
