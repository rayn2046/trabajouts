<?php
session_start();
require 'conexion.php';

if ($_SESSION['user_type'] !== 'alumno') {
    die("Acceso denegado");
}

$trabajo_id = $_POST['trabajo_id'];
$alumno_id = $_SESSION['user_id'];
$archivo = $_FILES['archivo']['name'];
$ruta = "uploads/" . $archivo;

if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
    $sql = "INSERT INTO entregas (trabajo_id, alumno_id, archivo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $trabajo_id, $alumno_id, $ruta);

    if ($stmt->execute()) {
        echo "Trabajo subido correctamente.";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Error al subir el archivo.";
}
$conn->close();
?>
