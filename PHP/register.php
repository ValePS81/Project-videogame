<?php
session_start();
include('conexion.php');

// Validar que los datos llegaron
if (
    isset($_POST['usuario']) && isset($_POST['contraseña']) && isset($_POST['correo']) &&
    isset($_POST['nombre']) && isset($_POST['apellidos']) &&
    isset($_POST['fecha_nacimiento']) && isset($_POST['rol'])
) {
    $usuario = $_POST['usuario'];
    $contraseña = sha1($_POST['contraseña']); // Puedes usar password_hash también
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $rol = $_POST['rol'];

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuario (usuario, contraseña, correo, nombre, apellidos, fecha_nacimiento, rol)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $usuario, $contraseña, $correo, $nombre, $apellidos, $fecha_nacimiento, $rol);

    if ($stmt->execute()) {
        header("Location: ../HTML/index.html");
        exit();

    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "Faltan datos"]);
}
?>
