<?php
include('conexion.php');
$resultado = $conn->query("SELECT * FROM usuario");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle shadow-sm bg-white">
        <thead class="table-primary text-center">
          <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $resultado->fetch_assoc()): ?>
            <tr>
              <td class="text-center"><?= $row['id_usuario'] ?></td>
              <td><?= $row['usuario'] ?></td>
              <td><?= $row['correo'] ?></td>
              <td><?= $row['nombre'] ?></td>
              <td><?= $row['apellidos'] ?></td>
              <td><?= $row['rol'] ?></td>
              <td class="text-center">
                <span class="badge <?= $row['estado'] ? 'bg-success' : 'bg-secondary' ?>">
                  <?= $row['estado'] ? 'Activo' : 'Inactivo' ?>
                </span>
              </td>
              <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning editar-btn" data-id="<?= $row['id_usuario'] ?>">Editar</a>
                <a href="eliminar_usuario.php?id=<?= $row['id_usuario'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<!-- Modal -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="contenidoModal">
        <!-- Aquí se cargará el formulario -->
      </div>
    </div>
  </div>
</div>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.editar-btn').click(function(e) {
      e.preventDefault();
      var id = $(this).data('id');

      // Cargar formulario por AJAX
      $.get('editar_usuario.php', { id: id }, function(data) {
        $('#contenidoModal').html(data);
        var modal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
        modal.show();
      });
    });
  });
</script>


<?php $conn->close(); ?>