<?php
session_start();
require 'conexion.php';

if ($_SESSION['user_type'] !== 'docente') {
    die("Acceso denegado");
}

$entrega_id = $_POST['entrega_id'];
$nota = $_POST['nota'];

$sql = "UPDATE entregas SET nota = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $nota, $entrega_id);

if ($stmt->execute()) {
    echo "Nota asignada correctamente.";
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
