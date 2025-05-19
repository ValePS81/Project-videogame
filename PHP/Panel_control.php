<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../HTML/Login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Panel de Administrador</span>
    <span class="text-white">Bienvenido, <?= $_SESSION['usuario'] ?></span>
    <a href="../HTML/Login.html" class="btn btn-outline-light">Cerrar sesión</a>
  </div>
</nav>

<div class="container">
  <div class="row">
    <!-- Gestión de Usuarios -->
    <div class="col-lg-8 mb-4">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Gestión de Usuarios</h5>
        </div>
        <div class="card-body">
          <?php include 'listar_usuarios.php'; ?>
        </div>
      </div>
    </div>
    <!-- Gestión del Juego (Listado + Subida) -->
<div class="col-lg-4">
  <div class="card shadow">
    <div class="card-header bg-warning text-dark">
      <h5 class="mb-0">Gestión del Juego</h5>
    </div>
    <div class="card-body">

      <!-- Lista de versiones -->
      <h6 class="text-secondary">Versiones Subidas</h6>
      <?php
        include 'conexion.php'; // asegúrate de tener este archivo con $conn definido

        $sql = "SELECT version, archivo, fecha_subida FROM version_videojuego ORDER BY fecha_subida DESC";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
          echo '<ul class="list-group mb-4">';
          while ($fila = $resultado->fetch_assoc()) {
            echo '<li class="list-group-item">';
            echo '<strong>Versión:</strong> ' . htmlspecialchars($fila['version']) . '<br>';
            echo '<strong>Archivo:</strong> <a href="uploads/' . urlencode($fila['archivo']) . '" download>' . htmlspecialchars($fila['archivo']) . '</a><br>';
            echo '<small class="text-muted">Subido el: ' . $fila['fecha_subida'] . '</small>';
            echo '</li>';
          }
          echo '</ul>';
        } else {
          echo '<p class="text-muted">No hay versiones registradas aún.</p>';
        }

        $conn->close();
      ?>

      <!-- Formulario de subida -->
      <h6 class="text-secondary">Subir Nueva Versión</h6>
      <form action="subir_version.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Versión</label>
          <input type="text" name="version" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Archivo del juego (.zip)</label>
          <input type="file" name="archivo" accept=".zip" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Subir versión</button>
      </form>
    </div>
  </div>
</div>
</div>

<footer class="text-center mt-5 mb-3 text-muted">
  <small>&copy; <?= date('Y') ?> Panel de Gestión - GameProfession</small>
</footer>

</body>
</html>