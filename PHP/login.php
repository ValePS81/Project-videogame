<?php
session_start();
include('conexion.php');

$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data['usuario'];
$contraseña = sha1($data['contraseña']);

$sql = "SELECT * FROM usuario WHERE usuario = ? AND contraseña = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $contraseña);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $_SESSION['usuario' ] = $usuario;
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>