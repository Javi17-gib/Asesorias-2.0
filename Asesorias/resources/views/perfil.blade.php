<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mi Perfil</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
body { background: #f2f2f2; font-family: Arial, sans-serif;}
.perfil-container { max-width: 450px; margin: 60px auto; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.15); text-align: center; }
.foto-perfil { width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 4px solid #0d6efd; position: relative; }
.btn-subir-foto { position: absolute; bottom: 0; right: 0; background: #0d6efd; border-radius: 50%; width: 35px; height: 35px; border: none; color: white; cursor: pointer; font-size: 18px; }
.input-nombre { margin-top: 20px; }
.btn-actualizar { margin-top: 15px; width: 100%; }
.btn-regresar { margin-top: 10px; width: 100%; }
.foto-wrapper { position: relative; display: inline-block; }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="perfil-container">
    <h2 class="mb-3">Mi Perfil</h2>
    <p>Cambia tu foto de perfil y tu nombre.</p>

    <form id="perfilForm" enctype="multipart/form-data">
        <div class="foto-wrapper mb-3">
            <img src="{{ $usuario->foto_perfil ? asset('storage/' . $usuario->foto_perfil) : asset('img/default.jpeg') }}" 
                 alt="Foto de perfil" class="foto-perfil" id="fotoPerfilPreview">
            <label class="btn-subir-foto" title="Cambiar foto">
                &#128247;
                <input type="file" name="foto" accept="image/*" style="display:none;">
            </label>
        </div>

        <div class="mb-3 input-nombre">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ $usuario->nombre }}" required>
        </div>

        <button type="submit" class="btn btn-primary btn-actualizar">Actualizar perfil</button>
    </form>

    <a href="{{ url()->previous() }}" class="btn btn-danger btn-regresar">Regresar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#perfilForm').on('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);
    const token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('perfil.actualizar') }}",
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token },
        data: formData,
        processData: false,
        contentType: false,
        success: function(res){
    Swal.fire({
        icon: 'success',
        title: '¡Perfil actualizado!',
        text: res.mensaje,
        confirmButtonText: 'OK'
    });

    // Actualiza la foto del perfil en la página de perfil
    if(res.foto_perfil_url){
        $('#fotoPerfilPreview').attr('src', res.foto_perfil_url + '?' + new Date().getTime());
    }

    // Actualiza la foto en el header también
    $('header img.rounded-circle').attr('src', res.foto_perfil_url + '?' + new Date().getTime());
}
,
        error: function(err){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el perfil.'
            });
        }
    });
});
</script>

</body>
</html>
