<?php
session_start();
require 'conexion.php'; // Archivo de conexión a la BD

if ($_SESSION['user_type'] !== 'docente') {
    die("Acceso denegado");
}

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_entrega = $_POST['fecha_entrega'];
$grupo = $_POST['grupo'];
$profesor_id = $_SESSION['user_id'];

$sql = "INSERT INTO trabajos (titulo, descripcion, fecha_entrega, grupo, profesor_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $titulo, $descripcion, $fecha_entrega, $grupo, $profesor_id);

if ($stmt->execute()) {
    echo "Trabajo asignado correctamente.";
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();
$conn->close();
?>

