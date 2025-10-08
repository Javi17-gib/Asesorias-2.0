@php
$usuario_nombre = session('usuario_nombre', 'Invitado');
$foto_usuario = asset('img/default.jpeg');
@endphp

<header class="position-relative bg-purple-700 p-2" style="background-color:#541469;">
    <!-- Título centrado -->
    <h1 style="font-family: 'Times New Roman', serif; font-size:60px; color:white;" 
        class="position-absolute top-50 start-50 translate-middle mb-0">
        {{ $materia->nombre ?? 'Materia' }}
    </h1>

    <!-- Perfil de usuario a la derecha -->
    <div class="d-flex align-items-center position-relative" style="justify-content:flex-end; padding-right:20px;">
        <img src="{{ $foto_usuario }}" alt="Usuario" class="rounded-circle me-2" style="width:40px; height:40px; object-fit:cover;">
        <div class="dropdown">
            <a class="btn btn-sm btn-outline-light dropdown-toggle" href="#" role="button" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-controls="userMenu">
                {{ $usuario_nombre }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" id="userMenu">
                <li><a href="#" class="dropdown-item"><i class="bi bi-person-fill"></i> Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a href="{{ route('logout') }}" class="dropdown-item"><i class="bi bi-box-arrow-in-left"></i> Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>

    <!-- Menú principal debajo del título -->
    <nav class="mt-5">
        <ul class="nav justify-content-center">
            <li class="nav-item mx-5">
                <a class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Inicio</a>
            </li>
            <li class="nav-item mx-5">
                <a class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">Preguntas</a>
            </li>
            <li class="nav-item mx-5">
                <a id="openChatbot" class="nav-link" href="#" style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color:white;">ChatBot</a>
            </li>
        </ul>
    </nav>
</header>

<!-- Chatbot Sidebar -->
<div id="chatbotSidebar" role="dialog" aria-modal="true" aria-labelledby="chatbotTitle" style="
    position: fixed;
    top: 0;
    right: -350px;
    width: 350px;
    height: 100vh;
    background-color: #f9f9f9;
    box-shadow: -3px 0 8px rgba(0,0,0,0.2);
    transition: right 0.3s ease;
    z-index: 1050;
    display: flex;
    flex-direction: column;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
">
    <header style="padding: 15px; background-color: #541469; color: white; font-size: 20px; font-weight: 700; display: flex; justify-content: space-between; align-items: center;">
        <span id="chatbotTitle">ChatBot</span>
        <button id="closeChatbot" aria-label="Cerrar chatbot" style="background: none; border: none; color: white; font-size: 28px; cursor: pointer; line-height: 1;">&times;</button>
    </header>
    <div id="chatbotContent" style="
        flex-grow: 1;
        padding: 15px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background-color: white;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    ">
        <p style="color: #555; font-style: italic;">Hola, soy tu asistente. ¿En qué puedo ayudarte?</p>
    </div>
    <form id="chatbotForm" style="display: flex; padding: 10px; background-color: #f0f0f0;">
        <input id="chatbotInput" type="text" placeholder="Escribe tu mensaje..." autocomplete="off" aria-label="Escribe tu mensaje" required
            style="flex-grow: 1; padding: 10px 15px; border: 1px solid #ccc; border-radius: 25px; outline: none; font-size: 16px;">
        <button type="submit" style="margin-left: 10px; background-color: #541469; border: none; color: white; padding: 10px 18px; border-radius: 25px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;">
            Enviar
        </button>
    </form>
</div>

<style>
    #chatbotSidebar p {
        max-width: 75%;
        padding: 10px 15px;
        border-radius: 20px;
        margin: 0;
    }
    #chatbotSidebar p.user-message {
        background-color: #d1e7dd;
        color: #0f5132;
        align-self: flex-end;
        font-weight: 600;
    }
    #chatbotSidebar p.bot-message {
        background-color: #e2e3e5;
        color: #41464b;
        align-self: flex-start;
    }
    #chatbotSidebar p.typing {
        font-style: italic;
        color: #888;
        text-align: left;
        max-width: 100%;
        background: none;
        padding: 0;
    }
    #chatbotSidebar::-webkit-scrollbar {
        width: 8px;
    }
    #chatbotSidebar::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.1);
        border-radius: 4px;
    }
    #chatbotSidebar::-webkit-scrollbar-track {
        background: transparent;
    }
</style>
