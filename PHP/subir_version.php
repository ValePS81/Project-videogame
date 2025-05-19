<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $version = $_POST['version'];
        $nombreArchivo = basename($_FILES["archivo"]["name"]);
        $rutaDestino = 'uploads/' . $nombreArchivo;

        // Crear directorio si no existe
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Mover el archivo al servidor
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaDestino)) {
            // Guardar en la base de datos
            $stmt = $conn->prepare("INSERT INTO version_videojuego (version, archivo) VALUES (?, ?)");
            $stmt->bind_param("ss", $version, $nombreArchivo);

            if ($stmt->execute()) {
                header("Location: Panel_control.php");
                exit();
            } else {
                echo "Error al guardar en la base de datos: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al mover el archivo.";
        }
    } else {
        echo "Error al subir el archivo: " . $_FILES['archivo']['error'];
    }
}

$conn->close();
?>