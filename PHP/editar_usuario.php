<?php
include('conexion.php');

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    $conn->query("UPDATE usuario SET nombre='$nombre', apellidos='$apellidos', correo='$correo', rol='$rol', estado='$estado' WHERE id_usuario=$id");
    echo "ok";
    exit();
}

$resultado = $conn->query("SELECT * FROM usuario WHERE id_usuario=$id");
$usuario = $resultado->fetch_assoc();
?>

<form id="formEditarUsuario">
  <input type="hidden" name="id" value="<?= $usuario['id_usuario'] ?>">
  <div class="mb-3">
    <label>Nombre:</label>
    <input type="text" class="form-control" name="nombre" value="<?= $usuario['nombre'] ?>">
  </div>
  <div class="mb-3">
    <label>Apellidos:</label>
    <input type="text" class="form-control" name="apellidos" value="<?= $usuario['apellidos'] ?>">
  </div>
  <div class="mb-3">
    <label>Correo:</label>
    <input type="email" class="form-control" name="correo" value="<?= $usuario['correo'] ?>">
  </div>
  <div class="mb-3">
    <label>Rol:</label>
    <select name="rol" class="form-select">
      <option value="estudiante" <?= $usuario['rol'] == 'estudiante' ? 'selected' : '' ?>>Estudiante</option>
      <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Admin</option>
      <option value="profesor" <?= $usuario['rol'] == 'profesor' ? 'selected' : '' ?>>Profesor</option>
    </select>
  </div>
  <div class="mb-3">
    <label>Estado:</label>
    <select name="estado" class="form-select">
      <option value="1" <?= $usuario['estado'] == 1 ? 'selected' : '' ?>>Activo</option>
      <option value="0" <?= $usuario['estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
    </select>
  </div>
  <div class="text-end">
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
  </div>
</form>

<script>
  $('#formEditarUsuario').on('submit', function(e) {
    e.preventDefault();
    $.post('editar_usuario.php?id=<?= $usuario['id_usuario'] ?>', $(this).serialize(), function(response) {
      if (response.trim() === "ok") {
        location.reload(); // Recarga la tabla al guardar
      } else {
        alert('Error al guardar los cambios');
      }
    });
  });
</script>
