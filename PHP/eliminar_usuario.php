<?php
include('conexion.php');
$id = $_GET['id'];
$conn->query("UPDATE usuario SET estado=0 WHERE id_usuario = $id");
header("Location: Panel_control.php");
exit();
?>