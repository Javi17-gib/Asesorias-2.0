<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asesorías</title>

  {{-- Estilos locales --}}
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  {{-- Google Fonts & Iconos --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" />
</head>
<body>

<header>
  <div id="logo">
    <img src="{{ asset('img/tec.jpg') }}" alt="Logo">
  </div>

  <nav>
    <ul>
      <li><h1>Asesorías Académicas</h1></li>
      <li><a href="#" class="activado">Inicio</a></li>
      <li class="dropdown">
        <a href="#">Materias</a>
        <ul class="submenu">
          <li><a href="#" onclick="abrirModal()">➕ Nueva Materia</a></li>
          <?php
          $conexion = new mysqli("localhost", "root", "", "asesorias");
          if ($conexion->connect_error) {
              die("Error de conexión: " . $conexion->connect_error);
          }
          $result = $conexion->query("SELECT * FROM materias ORDER BY nombre ASC");
          while ($row = $result->fetch_assoc()) {
              echo '<li>';
              echo '<a href="login.php?materia_id=' . (int)$row['id'] . '">' . htmlspecialchars($row['nombre']) . '</a>';
              echo '</li>';
          }
          $conexion->close();
          ?>
        </ul>
      </li>
      <li><a href="#">Salir</a></li>
    </ul>
  </nav>
</header>

<!-- Sección Principal -->
<section class="main">
  <video muted autoplay loop src="{{ asset('img/tec.mp4') }}"></video>
</section>

<!-- Modal Nueva Materia -->
<div id="modalMateria" class="modal">
  <div class="modal-content">
    <span class="close" onclick="cerrarModal()"><i class="bi bi-x-circle"></i></span>
    <h2>Nueva Materia</h2>
    <form id="formNuevaMateria">
      <input type="text" name="nombre" placeholder="Nombre de la materia" required>
      <button type="submit">Guardar</button>
    </form>
  </div>
</div>

{{-- Scripts locales --}}
<script src="{{ asset('js/nuevaMateria.js') }}"></script>

<script>
  function eliminarAsesoria(boton) {
    const item = boton.parentElement;
    item.remove();
  }
</script>

</body>
</html>
