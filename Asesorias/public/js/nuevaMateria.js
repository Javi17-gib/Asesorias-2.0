const modalMateria = new bootstrap.Modal(document.getElementById('modalMateria'));

function abrirModal() {
    modalMateria.show();
}

function cerrarModal() {
    modalMateria.hide();
    document.getElementById("formNuevaMateria").reset();
    document.getElementById("mensaje").innerText = '';
}

document.getElementById("formNuevaMateria").addEventListener("submit", async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    try {
        const response = await fetch(urlMateriasStore, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": formData.get('_token')
            },
            body: formData
        });

        const data = await response.json();

        if(data.success){
            const ul = document.querySelector('.dropdown-menu');
            const li = document.createElement('li');
            li.innerHTML = `<a class="dropdown-item" href="login.php?materia_id=${data.materia.id}">${data.materia.nombre} (${data.materia.codigo_materia})</a>`;
            ul.appendChild(li);

            document.getElementById("mensaje").innerText = data.mensaje;
            this.reset();
        } else {
            document.getElementById("mensaje").innerText = 'Error al guardar la materia.';
        }
    } catch(err) {
        console.error(err);
        alert("Error en la petición. Revisa la consola.");
    }
});
