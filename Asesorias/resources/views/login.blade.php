<?php
session_start();

if (isset($_GET['materia_id'])) {
    $id = intval($_GET['materia_id']);
    $stmt = $conexion->prepare("SELECT nombre FROM materias WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $_SESSION['materia'] = $row['nombre']; // Guarda la materia en sesión
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // REGISTRO
    if (isset($_POST['accion']) && $_POST['accion'] === 'registrar') {
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);

        if ($nombre === "" || $correo === "" || $contrasena === "") {
            header("Location: login.php?error=campos_vacios");
            exit;
        }

        // Verificar si el correo ya existe
        $verificar = $conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
        $verificar->bind_param("s", $correo);
        $verificar->execute();
        $resultado = $verificar->get_result();

        if ($resultado->num_rows > 0) {
            header("Location: login.php?error=usuario_existente");
            exit;
        }

        // Insertar usuario nuevo
        $stmt = $conexion->prepare("INSERT INTO usuario (nombre, correo, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $correo, $contrasena);
        if($stmt->execute()){
            header("Location: login.php?registro=exitoso");
            exit;
        } else {
            header("Location: login.php?error=bd");
            exit;
        }
    }

    // LOGIN
    if (isset($_POST['accion']) && $_POST['accion'] === 'login') {
        $correo = trim($_POST['txtemail']);
        $contrasena = trim($_POST['txtpassword']);

        if ($correo === "" || $contrasena === "") {
            header("Location: login.php?error=campos_vacios");
            exit;
        }

        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ? AND contrasena = ?");
        $stmt->bind_param("ss", $correo, $contrasena);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            $_SESSION['id_usuario'] = $usuario['id']; // <- corregido
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['correo'] = $usuario['correo'];
            header("Location: inicio.php");
            exit;
        } else {
            header("Location: login.php?error=login_invalido");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Asesorías</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<div class="fondo">
    <!-- Botón para cerrar -->
    <a href="/Inicio" class="icono-cerrar"><i class="ri-close-line"></i></a>

    <!-- Login -->
    <div class="contenedor-form login">
        <h2>Iniciar Sesión</h2>
        <form method="post" id="loginForm">
            <input type="hidden" name="accion" value="login" />

            <div class="contenedor-input">
                <span class="icono"><i class="ri-mail-fill"></i></span>
                <input name="txtemail" type="email" required />
                <label>Email</label>
            </div>

            <div class="contenedor-input">
                <span class="icono"><i class="ri-lock-2-fill"></i></span>
                <input name="txtpassword" type="password" required />
                <label>Contraseña</label>
            </div>

            <div class="recordar">
                <label><input type="checkbox" />Recordar sesión</label>
                <a href="#">¿Olvidaste la Contraseña?</a>
            </div>

            <button type="submit" class="btn">Iniciar Sesión</button>

            <div class="registrar">
                <p>¿No tienes cuenta? <a href="#" class="registrar-link">Registrarse</a></p>
            </div>
        </form>
    </div>

    <!-- Registro -->
    <div class="contenedor-form registrar">
        <h2>Registrarse</h2>
        <form method="post">
            <input type="hidden" name="accion" value="registrar" />

            <div class="contenedor-input">
                <span class="icono"><i class="ri-user-fill"></i></span>
                <input name="nombre" type="text" required />
                <label>Nombre</label>
            </div>

           <!-- <div class="contenedor-input">
                <span class="icono"><i class="ri-user-fill"></i></span>
                <input name="contrasena" type="password" required />
                <label>Apellido Paterno</label>
            </div>

            <div class="contenedor-input">
                <span class="icono"><i class="ri-user-fill"></i></span>
                <input name="contrasena" type="password" required />
                <label>Apellido Materno</label>
            </div> -->

            <div class="contenedor-input">
                <span class="icono"><i class="ri-mail-fill"></i></span>
                <input name="correo" type="email" required />
                <label>Email</label>
            </div>

            <div class="contenedor-input">
                <span class="icono"><i class="ri-lock-2-fill"></i></span>
                <input name="contrasena" type="password" required />
                <label>Contraseña</label>
            </div>

            <div class="recordar">
                <label><input type="checkbox" required />Acepto los términos y condiciones</label>
            </div>

            <button type="submit" class="btn">Registrarme</button>

            <div class="registrar">
                <p>¿Tienes una cuenta? <a href="#" class="login-link">Iniciar Sesión</a></p>
            </div>
        </form>
    </div>
</div>

<script src="../JS/login.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_GET['error']) && $_GET['error'] === 'login_invalido') { ?>
<script>
Swal.fire({ icon: 'error', title: 'Error', text: 'Correo o contraseña incorrectos.' });
</script>
<?php } ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'usuario_existente') { ?>
<script>
Swal.fire({ icon: 'error', title: 'Error', text: 'El correo ya está registrado.' });
</script>
<?php } ?>

<?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso') { ?>
<script>
Swal.fire({ icon: 'success', title: '¡Registro exitoso!', text: 'Ya puedes iniciar sesión.' });
</script>
<?php } ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'campos_vacios') { ?>
<script>
Swal.fire({ icon: 'warning', title: 'Atención', text: 'Por favor llena todos los campos.' });
</script>
<?php } ?>

</body>
</html>
