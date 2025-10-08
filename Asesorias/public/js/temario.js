document.addEventListener("DOMContentLoaded", () => {
    // ---------------------- VARIABLES ----------------------
    const modalUnidad = new bootstrap.Modal(document.getElementById("modalUnidad"));
    const modalSubtema = new bootstrap.Modal(document.getElementById("modalSubtema"));
    const unidadesContainer = document.getElementById("unidadesContainer");
    const usuarioNivel = document.querySelector('meta[name="usuario-nivel"]')?.content || 'estudiante';
    const temarioApp = document.getElementById("temarioApp");
    const materiaId = temarioApp?.dataset.materiaId;

    const chatbotUrl = document.querySelector('meta[name="chatbot-url"]')?.content;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    const openBtn = document.getElementById('openChatbot');
    const closeBtn = document.getElementById('closeChatbot');
    const sidebar = document.getElementById('chatbotSidebar');
    const chatbotContent = document.getElementById('chatbotContent');
    const chatbotInput = document.getElementById('chatbotInput');
    const chatbotForm = document.getElementById('chatbotForm');

    // ---------------------- COLA DE MENSAJES ----------------------
    const messageQueue = [];
    let processingQueue = false;

    async function processQueue() {
        if (processingQueue || messageQueue.length === 0) return;

        processingQueue = true;
        const { message, typingElem } = messageQueue.shift();

        try {
            const res = await fetch(chatbotUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ message })
            });

            const data = await res.json();
            typingElem.remove();

            if (data && data.reply) {
                addMessage(data.reply, 'bot');
            } else if (data && data.error) {
                addMessage(data.error, 'bot'); // Manejo de rate limit u otros errores desde backend
            } else {
                addMessage('Lo siento, no pude procesar tu mensaje.', 'bot');
            }
        } catch (err) {
            typingElem.remove();
            addMessage('Error al conectarse con el servidor.', 'bot');
            console.error(err);
        } finally {
            processingQueue = false;
            processQueue(); // Procesa el siguiente mensaje en cola
        }
    }

    // ---------------------- MODALES ----------------------
    window.abrirModalUnidad = () => modalUnidad.show();
    window.abrirModalSubtema = (unidadId) => {
        document.getElementById("subtemaUnidadId").value = unidadId;
        modalSubtema.show();
    };

    // ---------------------- NUEVA UNIDAD ----------------------
    document.getElementById("formNuevaUnidad")?.addEventListener("submit", async function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch(`/materia/${materiaId}/unidad`, {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': csrfToken },
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

    // ---------------------- NUEVO SUBTEMA ----------------------
    document.getElementById("formNuevoSubtema")?.addEventListener("submit", async function(e){
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch("/subtemas", {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });

            if (!response.ok) {
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

    // ---------------------- DESCRIPCIÓN ----------------------
    if(usuarioNivel === 'docente' && typeof $ !== 'undefined'){
        $('#descripcionMateria').summernote({
            height: 250,
            placeholder: 'Escribe la descripción de la materia aquí...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('#guardarDescripcion').click(async function(){
            const contenido = $('#descripcionMateria').summernote('code');
            const materiaId = "{{ $materia->id }}";

            try {
                const res = await fetch(urlDescripcionStore, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ id_materia: materiaId, descripcion: contenido })
                });
                const data = await res.json();
                $('#mensajeDescripcion').text(data.success ? 'Descripción guardada correctamente' : data.mensaje || 'Error al guardar');
            } catch(e){
                console.error(e);
                $('#mensajeDescripcion').text('Error en la petición');
            }
        });
    }

    // ---------------------- CHATBOT ----------------------
    function addMessage(text, sender){
        const p = document.createElement('p');
        p.textContent = text;
        p.classList.add(sender==='user'?'user-message':'bot-message');
        chatbotContent.appendChild(p);
        chatbotContent.scrollTop = chatbotContent.scrollHeight;
    }

    function addTyping(){
        const p = document.createElement('p');
        p.textContent='Escribiendo...';
        p.classList.add('typing');
        chatbotContent.appendChild(p);
        chatbotContent.scrollTop = chatbotContent.scrollHeight;
        return p;
    }

    openBtn?.addEventListener('click', e => { e.preventDefault(); sidebar.style.right='0'; chatbotInput.focus(); });
    closeBtn?.addEventListener('click', () => sidebar.style.right='-350px');
    document.addEventListener('keydown', e => { if(e.key==='Escape') sidebar.style.right='-350px'; });

    chatbotForm?.addEventListener('submit', e=>{
        e.preventDefault();
        const message = chatbotInput.value.trim();
        if(!message) return;

        addMessage(message,'user');
        chatbotInput.value='';
        chatbotInput.focus();
        const typingElem = addTyping();

        // Agregamos el mensaje a la cola
        messageQueue.push({ message, typingElem });
        processQueue();
    });
});
