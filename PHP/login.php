<?php
session_start();
include('conexion.php');

$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data['usuario'];
$contraseña = sha1($data['contraseña']);

$sql = "SELECT * FROM usuario WHERE usuario = ? AND contraseña = ? AND estado=1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $contraseña);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $fila['rol']; // guardamos el rol en la sesión
    echo json_encode([
        "success" => true,
        "rol" => $fila['rol']
    ]);
} else {
    echo json_encode(["success" => false]);
}
?>