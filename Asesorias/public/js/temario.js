document.addEventListener("DOMContentLoaded", () => {

    const modalUnidad = new bootstrap.Modal(document.getElementById("modalUnidad"));
    const modalSubtema = new bootstrap.Modal(document.getElementById("modalSubtema"));

    const materiaId = document.getElementById("temarioApp").dataset.materiaId;

    // Abrir modales
    window.abrirModalUnidad = () => modalUnidad.show();
    window.abrirModalSubtema = (unidadId) => {
        document.getElementById("subtemaUnidadId").value = unidadId;
        modalSubtema.show();
    };

    // Guardar unidad AJAX
    document.getElementById("formNuevaUnidad").addEventListener("submit", async function(e){
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch(`/materia/${materiaId}/unidad`, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": formData.get('_token') },
                body: formData
            });

            const data = await response.json();

            if(data.success){
                this.reset();
                modalUnidad.hide();
                location.reload();
            } else {
                document.getElementById("mensajeUnidad").innerText = data.mensaje || 'Error';
            }
        } catch(err){
            console.error(err);
        }
    });

    // Guardar subtema AJAX
    document.getElementById("formNuevoSubtema").addEventListener("submit", async function(e){
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch(`/subtemas`, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": formData.get('_token') },
                body: formData
            });

            const data = await response.json();

            if(data.success){
                this.reset();
                modalSubtema.hide();
                location.reload();
            } else {
                document.getElementById("mensajeSubtema").innerText = data.mensaje || 'Error';
            }
        } catch(err){
            console.error(err);
        }
    });

});
